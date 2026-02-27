<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the profile management page.
     */
    public function index()
    {
        $admins = User::where('id', '!=', Auth::id())->orderBy('name')->get();
        return view('admin.profile', compact('admins'));
    }

    /**
     * Change the currently logged-in admin's own password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini salah.'])
                ->withInput();
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Add a new admin account.
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->username, // stored in email column for auth
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', "Admin \"{$request->name}\" berhasil ditambahkan.");
    }

    /**
     * Reset another admin's password (set to a new one chosen by current admin).
     */
    public function resetAdminPassword(Request $request, User $user)
    {
        // Prevent resetting your own password through this endpoint
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Gunakan form "Ganti Password" untuk mengubah password Anda sendiri.');
        }

        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', "Password admin \"{$user->name}\" berhasil direset.");
    }

    /**
     * Delete another admin account.
     */
    public function destroyAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Admin \"{$name}\" berhasil dihapus.");
    }
}
