<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/auth/register', [AuthController::class, 'register']);
Route::post('/v1/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/v1/auth/logout', [AuthController::class, 'logout']);

    Route::get('/v1/tasks', [TaskController::class, 'index']);
    Route::post('/v1/tasks', [TaskController::class, 'store']);
    Route::put('/v1/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/v1/tasks/{id}', [TaskController::class, 'destroy']);

    Route::get('/v1/schedules', [ScheduleController::class, 'index']);
    Route::post('/v1/schedules', [ScheduleController::class, 'store']);
    Route::delete('/v1/schedules/{id}', [ScheduleController::class, 'destroy']);

    Route::get('/v1/dashboard', [DashboardController::class, 'index']);

    Route::get('/v1/holidays', [HolidayController::class, 'index']);
});