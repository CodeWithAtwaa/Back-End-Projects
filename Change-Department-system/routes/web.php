<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/request/create', [StudentController::class, 'createRequest'])->name('request.create');
    Route::post('/request/store', [StudentController::class, 'storeRequest'])->name('request.store');
    Route::delete('/request/{id}', [StudentController::class, 'destroyRequest'])->name('request.destroy');
});



// Routes for Reviewers
Route::middleware(['auth', 'role:reviewer'])->prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('/dashboard', [ReviewerController::class, 'dashboard'])->name('dashboard');
    Route::post('/approve/{id}', [ReviewerController::class, 'approve'])->name('approve');
    Route::post('/reject/{id}', [ReviewerController::class, 'reject'])->name('reject');
});

//Routes for Admins
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manage Users
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('manageUsers');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('storeUser');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

    // Update request status (example)
    Route::put('/request/{id}/status', [AdminController::class, 'updateStatus'])->name('updateStatus');
});


