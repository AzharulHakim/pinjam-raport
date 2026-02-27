<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Loan;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = Student::count();
        $todayLoans = Loan::where('status', 'borrowed')
            ->with('student.schoolClass')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalActiveLoans = Loan::where('status', 'borrowed')->count();

        return view('admin.dashboard', compact('totalStudents', 'todayLoans', 'totalActiveLoans'));
    }



    public function manageStudents(Request $request)
    {
        $query = Student::query();

        // Search logic
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Default sort by NIS
        $students = $query->with('schoolClass')->orderBy('nis', 'asc')->paginate(10);
        $classes = SchoolClass::all();

        if ($request->ajax()) {
            return view('admin.students_table', compact('students'))->render();
        }

        return view('admin.students', compact('students', 'classes'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:students,nis',
            'name' => 'required',
        ]);
        Student::create($request->all());
        return back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function destroyStudent(Student $student)
    {
        $student->delete();
        return back()->with('success', 'Siswa berhasil dihapus');
    }

    public function bulkDestroyStudents(Request $request)
    {
        $request->validate([
            'nis_from' => 'required',
            'nis_to' => 'required',
        ], [
            'nis_from.required' => 'NIS awal wajib diisi.',
            'nis_to.required' => 'NIS akhir wajib diisi.',
        ]);

        $nisFrom = $request->nis_from;
        $nisTo = $request->nis_to;

        $deleted = Student::whereBetween('nis', [
            min($nisFrom, $nisTo),
            max($nisFrom, $nisTo),
        ])->delete();

        return back()->with('success', "Berhasil menghapus {$deleted} siswa dengan NIS {$nisFrom} s/d {$nisTo}.");
    }

    public function history(Request $request)
    {
        $query = Loan::with(['student.schoolClass', 'representative.schoolClass']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Date Filter
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $loans = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.history', compact('loans'));
    }

    public function destroyLoan(Loan $loan)
    {
        $loan->delete();
        return redirect()->route('admin.history')->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }

    public function bulkDestroyHistory(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $deleted = Loan::whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->delete();

        return redirect()->route('admin.history')->with('success', "Berhasil menghapus {$deleted} riwayat peminjaman.");
    }

    public function exportHistory(Request $request)
    {
        $query = Loan::with(['student.schoolClass', 'representative.schoolClass']);

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Also apply search if present, to consistency
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $loans = $query->orderBy('created_at', 'desc')->get();

        return response()->view('admin.history_export', compact('loans'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename=riwayat_peminjaman_' . date('Y-m-d') . '.xls');
    }

    public function updateStudent(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'required|unique:students,nis,' . $student->id,
            'name' => 'required',
        ]);

        $student->update($request->all());

        return back()->with('success', 'Data siswa berhasil diperbarui');
    }

    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $importer = new \App\Imports\StudentsImport();
        if ($importer->import($request->file('file')->path())) {
            return back()->with('success', 'Data siswa berhasil diimport');
        } else {
            return back()->withErrors(['file' => 'Gagal membaca file Excel. Pastikan format benar.']);
        }
    }
}
