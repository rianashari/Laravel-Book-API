<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// routes/api.php
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Routes accessible by all authenticated users (viewer, editor, admin)
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{book}', [BookController::class, 'show']);
    
    // Routes accessible by editor and admin
    Route::middleware('role:editor,admin')->group(function () {
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{book}', [BookController::class, 'update']);
    });
    
    // Routes accessible only by admin
    Route::middleware('role:admin')->group(function () {
        Route::delete('/books/{book}', [BookController::class, 'destroy']);
    });
});
