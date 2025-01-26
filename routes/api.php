<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\Permissions\PermissionsController;
use App\Http\Controllers\API\Admin\Roles\RolesController;
use App\Http\Controllers\API\Admin\Users\UsersController;
use App\Http\Middleware\ApiJsonResponseMiddleware;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//Admin
Route::prefix('admin')->group(function () {

    //Auth
    Route::prefix('auth')->group(function () {
        Route::post('/token', [AuthController::class, 'token']);
        Route::post('/logout', [AuthController::class, 'logOut']);
    });
    Route::middleware(['auth:sanctum', ApiJsonResponseMiddleware::class])->group(function () {

        //Roles
        Route::prefix('/roles')->group(function () {
            Route::get('/', [RolesController::class, 'index']);
            Route::get('/get-all-permission', [RolesController::class, 'getAllPermission']);
            Route::post('/store', [RolesController::class, 'store']);
            Route::get('/edit/{id}', [RolesController::class, 'edit']);
            Route::put('/update/{id}', [RolesController::class, 'update']);
            Route::delete('/delete/{id}', [RolesController::class, 'destroy']);
        });

        //Roles
        Route::prefix('/users')->group(function () {
            Route::get('/', [UsersController::class, 'index']);
            Route::get('/get-all-roles', [UsersController::class, 'getAllRoles']);
            Route::post('/store', [UsersController::class, 'store']);
            Route::get('/edit/{id}', [UsersController::class, 'edit']);
            Route::put('/update/{id}', [UsersController::class, 'update']);
            Route::delete('/delete/{id}', [UsersController::class, 'destroy']);
        });

        //Permissions
        Route::prefix('/permissions')->group(function () {
            Route::get('/', [PermissionsController::class, 'index']);
            Route::post('/store', [PermissionsController::class, 'store']);
            Route::get('/edit/{id}', [PermissionsController::class, 'edit']);
            Route::put('/update/{id}', [PermissionsController::class, 'update']);
            Route::delete('/delete/{id}', [PermissionsController::class,'destroy']);
        });
    });
});
