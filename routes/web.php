<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebAuthController;
use App\Http\Controllers\Web\WebStudentController;
use App\Http\Controllers\Web\WebIndustryController;
use App\Http\Controllers\Web\WebLecturerController;
use App\Http\Controllers\Web\WebDashboardController;
use App\Http\Controllers\Web\WebInternshipController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [WebDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/lecturer', [WebLecturerController::class, 'index']);
    // Add Student Management Routes
    Route::resource('students', WebStudentController::class)->names([
        'index' => 'admin.students.index',
        'create' => 'admin.students.create',
        'store' => 'admin.students.store',
        'edit' => 'admin.students.edit',
        'update' => 'admin.students.update',
        'destroy' => 'admin.students.destroy',
    ]);

    // Add Lecturer Management Routes
    Route::resource('lecturers', WebLecturerController::class)->names([
        'index' => 'admin.lecturers.index',
        'create' => 'admin.lecturers.create',
        'store' => 'admin.lecturers.store',
        'edit' => 'admin.lecturers.edit',
        'update' => 'admin.lecturers.update',
        'destroy' => 'admin.lecturers.destroy',
    ]);

    // Add Industry Management Routes
    Route::resource('industries', WebIndustryController::class)->names([
        'index' => 'admin.industries.index',
        'create' => 'admin.industries.create',
        'store' => 'admin.industries.store',
        'edit' => 'admin.industries.edit',
        'update' => 'admin.industries.update',
        'destroy' => 'admin.industries.destroy',
    ]);

    // Fix the internship deletion route
    Route::delete('/internships/{internship}', [WebStudentController::class, 'deleteInternship'])
        ->name('admin.internships.destroy')
        ->middleware('csrf');
        
    // Add Internship routes
    Route::post('/students/{student}/internships', [WebInternshipController::class, 'store'])
        ->name('admin.internships.store');
    Route::delete('/internships/{internship}', [WebInternshipController::class, 'destroy'])
        ->name('admin.internships.destroy');
});
