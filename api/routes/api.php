<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatisticController;
use App\Http\Controllers\UserTaskStatisticController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('tasks', TaskController::class);
    });

    Route::group(['prefix' => 'task-statistics'], function () {
        Route::get('/', [TaskStatisticController::class, 'index']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/{id}/statistics', [UserTaskStatisticController::class, 'index']);
    });

});
