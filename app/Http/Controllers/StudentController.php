<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Loan;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Auth::guard('student')->user();
        $activeLoan = $student->loans()->where('status', 'borrowed')->first();

        return view('student.dashboard', compact('student', 'activeLoan'));
    }

    public function createLoan()
    {
        $student = Auth::guard('student')->user();

        // Check if already has active loan
        if ($student->loans()->where('status', 'borrowed')->exists()) {
            return redirect()->route('student.dashboard')->with('error', 'Anda masih memiliki peminjaman aktif. Harap kembalikan terlebih dahulu.');
        }

        // Fetch options from database (filter out empty/null values)
        $levels = \App\Models\SchoolClass::select('level')->distinct()->whereNotNull('level')->where('level', '!=', '')->orderBy('level')->pluck('level');

        return view('student.loan', compact('levels'));
    }

    public function storeLoan(Request $request)
    {
        $request->validate([
            'borrower_class_level' => 'required',
            'borrower_major' => 'required',
            'borrower_class_letter' => 'required',
            'target_class_level' => 'required_if:is_representative,1',
            'target_major' => 'required_if:is_representative,1',
            'target_class_letter' => 'required_if:is_representative,1',
            'reason' => 'required',
            'photo_base64' => 'required',
            'is_representative' => 'nullable|boolean',
            'representative_nis' => 'nullable|required_if:is_representative,1|exists:students,nis',
        ], [
            'representative_nis.exists' => 'NIS Siswa yang diwakilkan tidak ditemukan.',
            'representative_nis.required_if' => 'NIS Siswa wajib diisi jika mewakilkan.',
            'target_class_level.required_if' => 'Tingkat Kelas Teman wajib diisi.',
            'target_major.required_if' => 'Jurusan Teman wajib diisi.',
            'target_class_letter.required_if' => 'Kelas Teman wajib diisi.',
        ]);

        $currentUser = Auth::guard('student')->user();
        $targetStudent = $currentUser;
        $representativeId = null;

        // Determine which class data to save (Always save the Target Student's class)
        $classLevel = $request->borrower_class_level;
        $major = $request->borrower_major;
        $classLetter = $request->borrower_class_letter;

        if ($request->is_representative && $request->representative_nis) {
            $targetStudent = \App\Models\Student::where('nis', $request->representative_nis)->first();
            $representativeId = $currentUser->id;

            // If Representative, use the Target's class info for the Loan Record
            $classLevel = $request->target_class_level;
            $major = $request->target_major;
            $classLetter = $request->target_class_letter;

            if ($targetStudent->id === $currentUser->id) {
                return redirect()->back()->with('error', 'Anda tidak perlu memilih opsi "Wakilkan" untuk meminjam atas nama sendiri.');
            }
        }

        // Check if TARGET student already has active loan
        if ($targetStudent->loans()->where('status', 'borrowed')->exists()) {
            $msg = $representativeId ? 'Siswa yang diwakilkan masih memiliki peminjaman aktif.' : 'Anda masih memiliki peminjaman aktif.';
            return redirect()->route('student.dashboard')->with('error', $msg);
        }

        if ($request->filled('photo_base64')) {
            try {
                $image = $request->input('photo_base64');
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'loan-photos/' . time() . '_' . uniqid() . '.jpg';

                \Illuminate\Support\Facades\Storage::disk('public')->put($imageName, base64_decode($image));
                $path = $imageName;
            } catch (\Throwable $e) {
                return back()->with('error', 'Gagal menyimpan foto: ' . $e->getMessage());
            }
        } else {
            return back()->with('error', 'Foto wajib diambil.');
        }

        Loan::create([
            'student_id' => $targetStudent->id,
            'representative_id' => $representativeId,
            'class_level' => $classLevel,
            'major' => $major,
            'class_letter' => $classLetter,
            'reason' => $request->reason,
            'photo_path' => $path,
            'status' => 'borrowed',
            'borrowed_at' => now(),
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function returnPage()
    {
        $student = Auth::guard('student')->user();
        $activeLoan = $student->loans()->where('status', 'borrowed')->first();

        return view('student.return', compact('activeLoan'));
    }

    public function returnLoan(Request $request)
    {
        $loan = null;

        if ($request->filled('loan_id')) {
            // Validate loan exists and is active
            $loan = Loan::where('id', $request->loan_id)->where('status', 'borrowed')->first();
        } else {
            // Default: User's own active loan
            $user = Auth::guard('student')->user();
            $loan = Loan::where('student_id', $user->id)->where('status', 'borrowed')->first();
        }

        if ($loan) {
            $loan->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);
            return redirect()->route('student.dashboard')->with('success', 'Raport berhasil dikembalikan.');
        }

        return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan atau sudah dikembalikan.');
    }

    public function searchStudent($nis)
    {
        $student = \App\Models\Student::where('nis', $nis)->first();
        if ($student) {
            // Check for active loan
            $activeLoan = $student->loans()->where('status', 'borrowed')->first();

            $loanData = null;
            if ($activeLoan) {
                $loanData = [
                    'id' => $activeLoan->id,
                    'borrowed_at' => \Carbon\Carbon::parse($activeLoan->borrowed_at)->translatedFormat('d F Y, H:i'),
                    'full_class' => "{$activeLoan->class_level} {$activeLoan->major} {$activeLoan->class_letter}",
                    'reason' => $activeLoan->reason
                ];
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'name' => $student->name,
                    'active_loan' => $loanData
                ]
            ]);
        }
        return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan']);
    }

    public function history()
    {
        $student = Auth::guard('student')->user();
        // Fetch specific fields needed for the history table, including representative info
        $loans = $student->loans()->with('representative')->orderBy('created_at', 'desc')->get();

        return view('student.history', compact('loans'));
    }

    public function getMajors(Request $request)
    {
        $majors = \App\Models\SchoolClass::where('level', $request->level)
            ->distinct()
            ->orderBy('major')
            ->pluck('major');
        return response()->json($majors);
    }

    public function getClasses(Request $request)
    {
        $classes = \App\Models\SchoolClass::where('level', $request->level)
            ->where('major', $request->major)
            ->distinct()
            ->orderBy('class_letter')
            ->pluck('class_letter');
        return response()->json($classes);
    }

    public function destroyLoan(Loan $loan)
    {
        // Verify ownership (either borrower or representative could potentially delete, but usually only admin or system clears history. 
        // Assuming student can delete their own history for now as requested)
        if ($loan->student_id !== Auth::guard('student')->id() && $loan->representative_id !== Auth::guard('student')->id()) {
            abort(403);
        }

        $loan->delete();

        return redirect()->route('student.history')->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }
}
