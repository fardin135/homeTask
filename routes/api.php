<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api','auth.jwt'])->group(function () {
    // Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // User Routes
    Route::middleware('role:SuperAdmin,Admin,User')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::apiResource('tags', TagController::class);
        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('tasks', TaskController::class);
    });
    
    //     Route::apiResource('projects', ProjectController::class);
    //     Route::apiResource('tasks', TaskController::class);
    // Admin Routes
    // Route::middleware('role:Admin,SuperAdmin')->group(function () {
    //     Route::get('/admin/users', [AdminController::class, 'allUsers']);
    //     Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser']);
    // });

    // SuperAdmin Routes
//     Route::middleware('role:SuperAdmin')->group(function () {
//         Route::get('/superadmins', [AdminController::class, 'allAdmins']);
//     });
});
