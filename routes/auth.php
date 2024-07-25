<?php

use App\Http\Controllers\API\Auth\Admin\AdminAuthController;
use App\Http\Controllers\API\Auth\Admin\AdminProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\ProfileController;

Route::controller(AuthController::class)->group(function () {
    //Auth Routes
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post("user", 'user');
        Route::post("logout", 'logout');
    });
    //Guest Routes
    Route::middleware('guest')->group(function () {
        Route::post("login", 'login');
        Route::post("register", 'register');
    });
});

Route::controller(ProfileController::class)->group(function () {
    //Auth Routes
    Route::middleware('auth:sanctum')->prefix('profile')->group(function () {
        Route::post("/", 'update');
        Route::get("/", 'show');
    });
});


// ---------------------Admin Routes---------------------------
Route::prefix('admin')->group(function () {
    Route::controller(AdminAuthController::class)->group(function () {
        //Auth Routes
        Route::middleware('auth:admin')->group(function () {
            Route::post("user", 'user');
            Route::post("logout", 'logout');
        });

        //Guest Routes
        Route::middleware('guest')->group(function () {
            Route::post("login", 'login');
        });
    });

    // Profile Routes
    Route::controller(AdminProfileController::class)->middleware("auth:admin")->group(function () {
        Route::post("/", 'update');
        Route::get("/", 'show');
    });
});


