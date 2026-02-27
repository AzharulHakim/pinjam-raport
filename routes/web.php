<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login.student');
})->name('home');

// Auth Routes
Route::get('/login/admin', [AuthController::class, 'loginAdmin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'authenticateAdmin']);
Route::get('/login/student', [AuthController::class, 'loginStudent'])->name('login.student');
Route::post('/login/student', [AuthController::class, 'authenticateStudent'])->name('login.student.post');
Route::post('/student/logout', [AuthController::class, 'logoutStudent'])->name('student.logout');
Route::post('/admin/logout', [AuthController::class, 'logoutAdmin'])->name('admin.logout');

// Admin Routes
Route::middleware(['auth:web'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');



    // Students
    Route::get('/students', [AdminController::class, 'manageStudents'])->name('students');
    Route::post('/students', [AdminController::class, 'storeStudent']);
    Route::put('/students/{student}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{student}', [AdminController::class, 'destroyStudent'])->name('students.destroy');
    Route::delete('/students-bulk-delete', [AdminController::class, 'bulkDestroyStudents'])->name('students.bulk_destroy');
    Route::post('/students/import', [AdminController::class, 'importStudents'])->name('students.import');

    // Class Management
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassController::class, 'index'])->name('index');
        Route::get('/{level}', [ClassController::class, 'showLevel'])->name('level');
        Route::post('/{level}/major', [ClassController::class, 'storeMajor'])->name('storeMajor');
        Route::get('/{level}/{major}', [ClassController::class, 'showMajor'])->name('major');
        Route::post('/{level}/{major}/class', [ClassController::class, 'storeClass'])->name('storeClass');
        Route::delete('/{level}/{major}/delete', [ClassController::class, 'destroyMajor'])->name('destroyMajor');
        Route::delete('/{id}', [ClassController::class, 'destroy'])->name('destroy');
    });

    // Loan History
    Route::get('/history', [AdminController::class, 'history'])->name('history');
    Route::delete('/history/{loan}', [AdminController::class, 'destroyLoan'])->name('history.destroy');
    Route::delete('/history/bulk-delete', [AdminController::class, 'bulkDestroyHistory'])->name('history.bulk_destroy');
    Route::get('/history/export', [AdminController::class, 'exportHistory'])->name('history.export');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/admins', [ProfileController::class, 'storeAdmin'])->name('profile.admins.store');
    Route::put('/profile/admins/{user}/reset-password', [ProfileController::class, 'resetAdminPassword'])->name('profile.admins.reset');
    Route::delete('/profile/admins/{user}', [ProfileController::class, 'destroyAdmin'])->name('profile.admins.destroy');
});

// Student Routes
Route::middleware(['auth:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

    // Loan Page
    Route::get('/loan', [StudentController::class, 'createLoan'])->name('loan.create');
    Route::post('/loan', [StudentController::class, 'storeLoan'])->name('loan.store');

    // Return Page
    Route::get('/return', [StudentController::class, 'returnPage'])->name('loan.return_page');
    Route::post('/return', [StudentController::class, 'returnLoan'])->name('return.store');

    // AJAX Search
    Route::get('/search/{nis}', [StudentController::class, 'searchStudent'])->name('search');
    Route::get('/majors', [StudentController::class, 'getMajors'])->name('getMajors');
    Route::get('/classes', [StudentController::class, 'getClasses'])->name('getClasses');

    // Loan History
    Route::get('/history', [StudentController::class, 'history'])->name('history');
    Route::delete('/history/{loan}', [StudentController::class, 'destroyLoan'])->name('history.destroy');
});
