<?php

use App\Http\Controllers\API\Auth\Admin\AdminController;
use App\Http\Controllers\API\V1\Appointments\AppointmentController;
use App\Http\Controllers\API\V1\Favorites\FavoriteController;
use App\Http\Controllers\API\V1\Owners\OwnerController;
use App\Http\Controllers\API\V1\Properties\PropertyActionController;
use App\Http\Controllers\API\V1\Properties\PropertyController;
use App\Http\Controllers\API\V1\Properties\PropertyListingController;
use App\Http\Controllers\API\V1\Reports\ReportController;
use App\Http\Controllers\API\V1\Users\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


require 'auth.php';

//AdminController routes
Route::prefix('admins')->middleware(['auth:sanctum'])->controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->middleware('superadmin');
    Route::get('/all', 'all')->middleware('superadmin');
    Route::get('/{id}', 'show')->middleware('superadmin');
    Route::post('/store', 'store')->middleware('superadmin');
    Route::get('/info/show', 'showInfo')->middleware('admin.or.superadmin');
    Route::delete('/destroy/{id}', 'destroy')->middleware('superadmin');
});


//Properties routes
Route::prefix('properties')->controller(PropertyController::class)->group(function () {
    Route::get('/', 'index')->middleware('optional.auth');
    Route::get('/all', 'all');
    Route::get('/{id}', 'show')->middleware('optional.auth');
    Route::post('/', 'store')->middleware(['auth:sanctum']);
    Route::put('/{id}', 'update')->middleware(['auth:sanctum']);
    Route::delete('/{id}', 'delete')->middleware(['auth:sanctum']);


            //Property actions routes
        Route::prefix('actions')->middleware(['auth:sanctum'])->controller(PropertyActionController::class)->group(function () {
            Route::get('/index', 'index')->middleware('superadmin');
            Route::get('/all', 'all')->middleware('superadmin');
            Route::get('/me', 'me')->middleware('admin');
            Route::post('/', 'store')->middleware(['admin.or.superadmin']);
            Route::delete('/{id}', 'delete')->middleware('superadmin');
        });

        //Property reports routes
        Route::prefix('reports')->middleware(['auth:sanctum'])->controller(ReportController::class)->group(function () {
            Route::get('/sales', 'sales')->middleware('admin.or.superadmin');
            Route::get('/actions', 'actions')->middleware('admin.or.superadmin');
            Route::get('/sales/{year}', 'adminSales')->middleware('superadmin');
            Route::get('/types', 'types')->middleware('admin.or.superadmin');
        });


        //Property listings routes
        Route::prefix('listings')->middleware(['auth:sanctum'])->controller(PropertyListingController::class)->group(function () {
            Route::get('/index', 'index')->middleware('superadmin');
            Route::get('/all', 'all')->middleware('superadmin');
            Route::get('/show/{id}', 'show')->middleware('superadmin');
            Route::get('/me', 'me')->middleware('admin');
            Route::post('/', 'store')->middleware('superadmin');
            Route::put('/', 'update')->middleware('superadmin');
            Route::delete('/{id}', 'delete')->middleware('superadmin');
        });
});


//Appointments routes
Route::prefix('appointments')->middleware(['auth:sanctum'])->controller(AppointmentController::class)->group(function () {
    Route::get('/', 'index')->middleware('superadmin');
    Route::get('/all', 'all')->middleware('superadmin');
    Route::get('/show/{id}', 'show')->middleware('superadmin');
    Route::get('/me', 'me')->middleware('admin');
    Route::post('/', 'store');
    Route::put('/{id}', 'update')->middleware('superadmin');
    Route::delete('/{id}', 'delete')->middleware('superadmin');
});

//owners routes
Route::prefix('owners')->middleware(['auth:sanctum','admin.or.superadmin'])->controller(OwnerController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/all', 'all');
    Route::get('/{id}', 'show');
    Route::delete('/{id}', 'delete');
});

//users routes
Route::prefix('users')->middleware(['auth:sanctum','superadmin'])->controller(UserController::class)->group(function () {
    Route::get('/', 'usersTable');
    Route::get('/{id}/properties', 'userPropertiesTable');
});

//Hidden Properties routes
Route::prefix('hidden-properties')->middleware(['auth:sanctum','admin.or.superadmin'])->controller(PropertyController::class)->group(function () {
    Route::get('/', 'hiddenProperties');
    Route::put('/{id}', 'hideProperty');
});

//Favorite Routes
Route::prefix('favorites')->middleware(['auth:sanctum'])->controller(FavoriteController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/all', 'all');
    Route::get('/popular', 'popularProperties')->middleware('admin.or.superadmin');
    Route::post('/{id}', 'toggle');
    Route::delete('/{id}', 'delete');
});
