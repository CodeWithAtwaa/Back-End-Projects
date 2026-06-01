<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BlogController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\CommentController;
use App\Http\Controllers\api\ContactController;
use App\Http\Controllers\api\Subscribers;
use Illuminate\Support\Facades\Route;


#-------------------- Subscriber Module --------------------
Route::controller(Subscribers::class)->group(function () {
    Route::post('/subscribers', 'store');
    Route::get('/subscribers', 'index');
});


#-------------------- Contacts Module --------------------
Route::post('/contact', ContactController::class);


#-------------------- Category Module --------------------
Route::get('/categories', [CategoryController::class, '__invoke']);


#-------------------- Auth Module ------------------------
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::middleware('auth:sanctum')->post('/logout', 'logout');
});


#-------------------- Blog Module ------------------------
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::patch('/blogs/{blog}', [BlogController::class, 'update']);
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
});



#-------------------- Comments Module ------------------------
Route::controller(CommentController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/comments', 'index')->name('comments.index');
    Route::post('/comments', 'store')->name('comments.store');
});
