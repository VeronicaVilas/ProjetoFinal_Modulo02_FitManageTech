<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckStudentPlanLimitToUser;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::get('exercises', [ExerciseController::class, 'index']);

    Route::post('students', [StudentController::class, 'store'])->middleware(CheckStudentPlanLimitToUser::class);
    Route::get('students', [StudentController::class, 'index']);
});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'store']);
