<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogBookController;
use App\Http\Controllers\GuidanceController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\HomeStudentController;
use App\Http\Controllers\HomeLecturerController;
use App\Http\Controllers\DetailStudentController;
use App\Http\Controllers\ProfileStudentController;
use App\Http\Controllers\ProfileLecturerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

Route::middleware(['auth:sanctum'])->prefix('/student')->group(function () {
    Route::get('/home', [HomeStudentController::class, 'index']);

    Route::resource('/guidance', GuidanceController::class);
    // Route::post('/guidance', [GuidanceController::class, 'store']);
    // Route::put('/guidance/{guidance}', [GuidanceController::class, 'update']);

    Route::resource('/logBook', LogBookController::class);
    
    Route::get('/profile', [ProfileStudentController::class, 'index']);
    
    Route::resource('/internship', InternshipController::class);
});

Route::middleware(['auth:sanctum'])->prefix('/lecturer')->group(function () {
    Route::get('/home', [HomeLecturerController::class, 'index']);

    Route::get('/detailStudent/{student}', [DetailStudentController::class, 'index']);
    Route::post('/addAssessment/{student}', [AssessmentController::class, 'store']);

    Route::put('/guidance/{guidance}', [DetailStudentController::class, 'update']);
    
    Route::get('/profile', [ProfileLecturerController::class, 'index']);
    
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/updateProfile', [UserController::class, 'update']);

    Route::post('/resetPassword', [AuthController::class, 'resetPassword']);
});

// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
