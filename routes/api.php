<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\Roles\RolesController;
use App\Http\Middleware\ApiJsonResponseMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//Admin
Route::prefix('admin')->group(function(){
    
    //Auth
    Route::prefix('auth')->group(function(){
        Route::post('/token',[AuthController::class,'token']);
    });
    Route::middleware(['auth:sanctum',ApiJsonResponseMiddleware::class])->group(function () {
        //Roles
        Route::prefix('/roles')->group(function () {
            Route::get('/',[RolesController::class, 'index']);
            Route::get('/create',[RolesController::class, 'create']);
            Route::post('/store',[RolesController::class, 'store']);
            Route::get('/edit/{id}',[RolesController::class, 'edit']);
            Route::put('/update/{id}',[RolesController::class, 'update']);
            Route::delete('/delete/{id}',[RolesController::class, 'destroy']);
        });
    });


});