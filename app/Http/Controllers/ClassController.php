<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    /**
     * Display the list of Levels (X, XI, XII).
     */
    public function index()
    {
        $levels = ['X', 'XI', 'XII'];
        return view('admin.classes.index', compact('levels'));
    }

    /**
     * Display the Majors for a specific Level.
     */
    public function showLevel($level)
    {
        // Get unique majors for this level
        $majors = SchoolClass::where('level', $level)
            ->select('major')
            ->distinct()
            ->orderBy('major')
            ->pluck('major');

        return view('admin.classes.level', compact('level', 'majors'));
    }

    /**
     * Store a new Major for a specific Level.
     * This creates a default class 'A' for the new major to establish it.
     */
    public function storeMajor(Request $request, $level)
    {
        $request->validate([
            'major' => 'required|string',
        ]);

        // Check if exists
        $exists = SchoolClass::where('level', $level)
            ->where('major', $request->major)
            ->exists();

        if ($exists) {
            return back()->withErrors(['major' => 'Jurusan sudah ada di tingkat ini.']);
        }

        SchoolClass::create([
            'level' => $level,
            'major' => $request->major,
            'class_letter' => 'A' // Default class
        ]);

        return back()->with('success', 'Jurusan berhasil ditambahkan.');
    }

    /**
     * Display the Classes (letters) for a specific Level and Major.
     */
    public function showMajor($level, $major)
    {
        $classes = SchoolClass::where('level', $level)
            ->where('major', $major)
            ->orderBy('class_letter')
            ->get();

        return view('admin.classes.major', compact('level', 'major', 'classes'));
    }

    /**
     * Store a new Class Letter for a specific Level and Major.
     */
    public function storeClass(Request $request, $level, $major)
    {
        $request->validate([
            'class_letter' => 'required|string|max:10',
        ]);

        $exists = SchoolClass::where('level', $level)
            ->where('major', $major)
            ->where('class_letter', $request->class_letter)
            ->exists();

        if ($exists) {
            return back()->withErrors(['class_letter' => 'Kelas sudah ada.']);
        }

        SchoolClass::create([
            'level' => $level,
            'major' => $major,
            'class_letter' => $request->class_letter
        ]);

        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Remove all classes under a specific Major for a Level.
     */
    public function destroyMajor($level, $major)
    {
        SchoolClass::where('level', $level)
            ->where('major', $major)
            ->delete();

        return redirect()->route('admin.classes.level', $level)
            ->with('success', "Jurusan \"{$major}\" beserta semua kelasnya berhasil dihapus.");
    }

    /**
     * Remove a class.
     */

    public function destroy($id)
    {
        $class = SchoolClass::findOrFail($id);
        $class->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}
