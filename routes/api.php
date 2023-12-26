<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentExportController;
use App\Http\Controllers\StudentWorkoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use App\Http\Middleware\CheckStudentPlanLimitToUser;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('exercises', [ExerciseController::class, 'store']);
    Route::get('exercises', [ExerciseController::class, 'index']);

    Route::post('students', [StudentController::class, 'store'])->middleware(CheckStudentPlanLimitToUser::class);
    Route::get('students', [StudentController::class, 'index']);
    Route::delete('students/{id}', [StudentController::class, 'destroy']);
    Route::put('students/{id}', [StudentController::class, 'update']);

    Route::post('workouts', [WorkoutController::class, 'store']);

    Route::get('students/{id}/workouts', [StudentWorkoutController::class, 'index']);

    Route::get('students/export', [StudentExportController::class, 'export']);

});

Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'store']);
