<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class AuthController extends Controller
{
    public function loginAdmin()
    {
        return view('auth.admin-login');
    }

    public function authenticateAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'], // Allow non-email username
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function loginStudent()
    {
        return view('auth.student-login');
    }

    public function authenticateStudent(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'name' => 'required',
        ]);

        $student = Student::where('nis', $request->nis)
            ->where('name', $request->name)
            ->first();

        if ($student) {
            Auth::guard('student')->login($student);
            $request->session()->regenerate();
            return redirect()->intended('student/dashboard');
        }

        return back()->withErrors([
            'nis' => 'Data siswa tidak ditemukan sesuai NIS dan Nama.',
        ]);
    }

    public function logoutStudent(Request $request)
    {
        Auth::guard('student')->logout();
        // $request->session()->regenerateToken();
        // Note: We do NOT invalidate the entire session here to preserve other guards (like admin)
        return redirect()->route('login.student');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('web')->logout();
        // $request->session()->regenerateToken();
        // Note: We do NOT invalidate the entire session here to preserve other guards
        return redirect()->route('login.admin');
    }
}
