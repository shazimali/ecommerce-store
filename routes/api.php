<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\controllers\API\Admin\Banners\BannersController;
use App\Http\Controllers\API\Admin\Categories\CategoryController;
use App\Http\Controllers\API\Admin\Permissions\PermissionsController;
use App\Http\Controllers\API\Admin\Products\ProductController;
use App\Http\Controllers\API\Admin\Roles\RolesController;
use App\Http\Controllers\API\Admin\SubCategories\subCategoryController;
use App\Http\Controllers\API\Admin\Users\UsersController;
use App\Http\Controllers\API\Admin\Websites\WebsitesController;
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
            Route::delete('/delete/{id}', [PermissionsController::class, 'destroy']);
        });

        //Websites
        Route::prefix('/websites')->group(function () {
            Route::get('/', [WebsitesController::class, 'index']);
            Route::post('/store', [WebsitesController::class, 'store']);
            Route::get('/edit/{id}', [WebsitesController::class, 'edit']);
            Route::put('/update/{id}', [WebsitesController::class, 'update']);
            Route::delete('/delete/{id}', [WebsitesController::class, 'destroy']);
        });

        //Categories
        Route::prefix('/categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/get-all-countries', [CategoryController::class, 'getAllCountries']);
            Route::post('/store', [CategoryController::class, 'store']);
            Route::get('/edit/{id}', [CategoryController::class, 'edit']);
            Route::put('/update/{id}', [CategoryController::class, 'update']);
            Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);
            Route::get('/get-all-websites', [CategoryController::class, 'getAllWebsites']);
        });

        //SubCategories
        Route::prefix('/subcategories')->group(function () {
            Route::get('/', [subCategoryController::class, 'index']);
            Route::get('/get-all-categories', [subCategoryController::class, 'getAllCategories']);
            Route::post('/store', [subCategoryController::class, 'store']);
            Route::get('/edit/{id}', [subCategoryController::class, 'edit']);
            Route::put('/update/{id}', [subCategoryController::class, 'update']);
            Route::delete('/delete/{id}', [subCategoryController::class, 'destroy']);
        });

        //Products
        Route::prefix('/products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/store', [ProductController::class, 'store']);
            Route::get('/edit/{id}', [ProductController::class, 'edit']);
            Route::put('/update/{id}', [ProductController::class, 'update']);
            Route::delete('/delete/{id}', [ProductController::class, 'destroy']);
            Route::get('/get-all-sub-categories', [ProductController::class, 'getAllSubCategories']);

            //Product Prices
            Route::prefix('/prices')->group(function () {
                Route::get('/{id}', [ProductController::class, 'getPrices']);
                Route::post('/store', [ProductController::class, 'storePrice']);
                Route::post('/edit/{id}', [ProductController::class, 'editPrice']);
                Route::post('/update/{id}', [ProductController::class, 'storePrice']);
                Route::post('/delete/{id}', [ProductController::class, 'deletePrice']);
            });
        });

        //Banners
        Route::prefix('/banners')->group(function () {
            Route::get('/', [BannersController::class, 'index']);
            Route::post('/store', [BannersController::class, 'store']);
            Route::get('/edit/{id}', [BannersController::class, 'edit']);
            Route::put('/update/{id}', [BannersController::class, 'update']);
            Route::delete('/delete/{id}', [BannersController::class, 'destroy']);
            Route::get('/get-all-websites', [BannersController::class, 'getAllWebsites']);
        });
    });
});
