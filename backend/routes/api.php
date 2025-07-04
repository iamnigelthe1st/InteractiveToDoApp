<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public Routes
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Authenticated Routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Authentication
    Route::get('/user', [AuthController::class, 'user'])->name('api.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('api.profile.update');
    Route::put('/password', [AuthController::class, 'updatePassword'])->name('api.password.update');

    // Todos
    Route::get('/todos', [TodoController::class, 'index'])->name('api.todos.index');
    Route::post('/todos', [TodoController::class, 'store'])->name('api.todos.store');
    Route::get('/todos/{todo}', [TodoController::class, 'show'])->name('api.todos.show');
    Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('api.todos.update');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('api.todos.destroy');
    Route::post('/todos/{todo}/complete', [TodoController::class, 'complete'])->name('api.todos.complete');
    Route::post('/todos/{todo}/archive', [TodoController::class, 'archive'])->name('api.todos.archive');

    // Stats
    Route::get('/stats', [TodoController::class, 'stats'])->name('api.todos.stats');
    Route::get('/categories', [TodoController::class, 'categories'])->name('api.todos.categories');
});

// Fallback Route
Route::fallback(function () {
    return response()->json([
        'message' => 'Endpoint not found. Please check the API documentation.',
        'status' => 404
    ], 404);
});