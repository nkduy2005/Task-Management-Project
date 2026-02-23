<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TaskAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post("/signup", [UserController::class, "signup"]);
Route::post("/login", [UserController::class, "login"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/logout", [UserController::class, "logout"]);
    Route::get("/tasks", [TaskController::class, "findTasksByIdUser"]);
    Route::post('/task', [TaskController::class, "createTask"]);
    Route::middleware(TaskAuthorization::class)->group(function () {
        Route::delete("/task/{slug}", [TaskController::class, "deleteTask"]);
        Route::get('/task/{slug}', [TaskController::class, "findTaskBySlug"]);
        Route::put('/task/{slug}/is-completed', [TaskController::class, "updateStatusTask"]);
        Route::put("/task/{slug}", [TaskController::class, "updateTask"]);
    });
});
