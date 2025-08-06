<?php

use App\Http\Controllers\API\Admin\AuthController;
use App\Http\Controllers\API\Admin\Banners\BannersController;
use App\Http\Controllers\API\Admin\Blogs\BlogsController;
use App\Http\Controllers\API\Admin\Categories\CategoryController;
use App\Http\Controllers\API\Admin\COD\CODController;
use App\Http\Controllers\API\Admin\Collections\CollectionsController;
use App\Http\Controllers\API\Admin\Coupons\CouponsController;
use App\Http\Controllers\API\Admin\Customers\CustomersController;
use App\Http\Controllers\API\Admin\Facilities\FacilitiesController;
use App\Http\Controllers\API\Admin\Orders\OrdersController;
use App\Http\Controllers\API\Admin\Pages\PagesController;
use App\Http\Controllers\API\Admin\Permissions\PermissionsController;
use App\Http\Controllers\API\Admin\ProductReviews\ProductReviewController;
use App\Http\Controllers\API\Admin\Products\ProductColors\ProductColorsController;
use App\Http\Controllers\API\Admin\Products\ProductController;
use App\Http\Controllers\API\Admin\Purchases\PurchasesController;
use App\Http\Controllers\API\Admin\Roles\RolesController;
use App\Http\Controllers\API\Admin\Settings\SettingsController;
use App\Http\Controllers\API\Admin\SocialMedias\SocialMediasController;
use App\Http\Controllers\API\Admin\SubCategories\subCategoryController;
use App\Http\Controllers\API\Admin\Suppliers\SupplierController;
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
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
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

        //Collections
        Route::prefix('/collections')->group(function () {
            Route::get('/', [CollectionsController::class, 'index']);
            Route::get('/get-all-extra', [CollectionsController::class, 'getAllExtra']);
            Route::post('/store', [CollectionsController::class, 'store']);
            Route::get('/edit/{id}', [CollectionsController::class, 'edit']);
            Route::post('/update/{id}', [CollectionsController::class, 'update']);
            Route::delete('/delete/{id}', [CollectionsController::class, 'destroy']);
        });

        //Categories
        Route::prefix('/categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::get('/get-all-countries', [CategoryController::class, 'getAllCountries']);
            Route::post('/store', [CategoryController::class, 'store']);
            Route::get('/edit/{id}', [CategoryController::class, 'edit']);
            Route::post('/update/{id}', [CategoryController::class, 'update']);
            Route::delete('/delete/{id}', [CategoryController::class, 'destroy']);
            Route::get('/get-all-websites', [CategoryController::class, 'getAllWebsites']);
        });

        //SubCategories
        Route::prefix('/subcategories')->group(function () {
            Route::get('/', [subCategoryController::class, 'index']);
            Route::get('/get-all-categories', [subCategoryController::class, 'getAllCategories']);
            Route::post('/store', [subCategoryController::class, 'store']);
            Route::get('/edit/{id}', [subCategoryController::class, 'edit']);
            Route::post('/update/{id}', [subCategoryController::class, 'update']);
            Route::delete('/delete/{id}', [subCategoryController::class, 'destroy']);
        });

        //Products
        Route::prefix('/products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/store', [ProductController::class, 'store']);
            Route::get('/edit/{id}', [ProductController::class, 'edit']);
            Route::post('/update/{id}', [ProductController::class, 'update']);
            Route::delete('/delete/{id}', [ProductController::class, 'destroy']);
            Route::get('/get-all-sub-categories', [ProductController::class, 'getAllSubCategories']);

            //Product Prices
            Route::prefix('/prices')->group(function () {
                Route::get('/{id}', [ProductController::class, 'getPrices']);
                Route::post('/store', [ProductController::class, 'storePrice']);
                Route::post('/edit/{id}', [ProductController::class, 'editPrice']);
                Route::put('/update/{id}', [ProductController::class, 'storePrice']);
                Route::delete('/delete/{id}', [ProductController::class, 'deletePrice']);
            });

            //ProductColors
            Route::prefix('/colors')->group(function () {
                Route::get('/{id}', [ProductColorsController::class, 'index']);
                Route::post('/store', [ProductColorsController::class, 'store']);
                Route::get('/edit/{id}', [ProductColorsController::class, 'edit']);
                Route::put('/update/{id}', [ProductColorsController::class, 'update']);
                Route::delete('/delete/{id}', [ProductColorsController::class, 'destroy']);
            });
        });

        //Banners
        Route::prefix('/banners')->group(function () {
            Route::get('/', [BannersController::class, 'index']);
            Route::post('/store', [BannersController::class, 'store']);
            Route::get('/edit/{id}', [BannersController::class, 'edit']);
            Route::post('/update/{id}', [BannersController::class, 'update']);
            Route::delete('/delete/{id}', [BannersController::class, 'destroy']);
            Route::get('/get-all-websites', [BannersController::class, 'getAllWebsites']);
        });



        //SocialMedias
        Route::prefix('/social-medias')->group(function () {
            Route::get('/', [SocialMediasController::class, 'index']);
            Route::post('/store', [SocialMediasController::class, 'store']);
            Route::get('/edit/{id}', [SocialMediasController::class,  'edit']);
            Route::post('/update/{id}', [SocialMediasController::class, 'update']);
            Route::delete('/delete/{id}', [SocialMediasController::class, 'destroy']);
            Route::get('/get-all-websites', [SocialMediasController::class, 'getAllWebsites']);
        });

        //Facilities
        Route::prefix('/facilities')->group(function () {
            Route::get('/', [FacilitiesController::class, 'index']);
            Route::post('/store', [FacilitiesController::class, 'store']);
            Route::get('/edit/{id}', [FacilitiesController::class, 'edit']);
            Route::post('/update/{id}', [FacilitiesController::class, 'update']);
            Route::delete('/delete/{id}', [FacilitiesController::class, 'destroy']);
            Route::get('/get-all-countries', [FacilitiesController::class, 'getAllCountries']);
        });

        //Suppliers
        Route::prefix('/suppliers')->group(function () {
            Route::get('/', [SupplierController::class, 'index']);
            Route::post('/store', [SupplierController::class, 'store']);
            Route::get('/edit/{id}', [SupplierController::class, 'edit']);
            Route::put('/update/{id}', [SupplierController::class, 'update']);
            Route::delete('/delete/{id}', [SupplierController::class, 'destroy']);
        });

        //Purchases
        Route::prefix('/purchases')->group(function () {
            Route::get('/', [PurchasesController::class, 'index']);
            Route::post('/store', [PurchasesController::class, 'store']);
            Route::get('/edit/{id}', [PurchasesController::class, 'edit']);
            Route::put('/update/{id}', [PurchasesController::class, 'update']);
            Route::delete('/delete/{id}', [PurchasesController::class, 'destroy']);
            Route::get('get-all-suppliers', [PurchasesController::class, 'getAllSuppliers']);
            Route::get('/fetch-invoice/{id}', [PurchasesController::class, 'getInvoice']);
        });

        //Settings
        Route::prefix('/settings')->group(function () {
            Route::get('/', [SettingsController::class, 'index']);
            Route::post('/store', [SettingsController::class, 'store']);
            Route::get('/edit/{id}', [SettingsController::class, 'edit']);
            Route::put('/update/{id}', [SettingsController::class, 'update']);
            Route::delete('/delete/{id}', [SettingsController::class, 'destroy']);
            Route::get('/get-all-countries', [SettingsController::class, 'getAllCountries']);
        });

        //Coupons
        Route::prefix('/coupons')->group(function () {
            Route::get('/', [CouponsController::class, 'index']);
            Route::post('/store', [CouponsController::class, 'store']);
            Route::get('/edit/{id}', [CouponsController::class, 'edit']);
            Route::put('/update/{id}', [CouponsController::class, 'update']);
            Route::delete('/delete/{id}', [CouponsController::class, 'destroy']);
            Route::get('/get-all-countries', [CouponsController::class, 'getAllCountries']);
        });

        //Blogs
        Route::prefix('/blogs')->group(function () {
            Route::get('/', [BlogsController::class, 'index']);
            Route::post('/store', [BlogsController::class, 'store']);
            Route::get('/edit/{id}', [BlogsController::class, 'edit']);
            Route::post('/update/{id}', [BlogsController::class, 'update']);
            Route::delete('/delete/{id}', [BlogsController::class, 'destroy']);
            Route::get('/get-all-countries', [BlogsController::class, 'getAllCountries']);
        });

        //COD
        Route::prefix('/cod')->group(function () {
            Route::get('/', [CODController::class, 'index']);
            Route::post('/store', [CODController::class, 'store']);
            Route::get('/edit/{id}', [CODController::class, 'edit']);
            Route::put('/update/{id}', [CODController::class, 'update']);
            Route::delete('/delete/{id}', [CODController::class, 'destroy']);
            Route::get('/get-all-countries', [CODController::class, 'getAllCountries']);
        });
        //Pages
        Route::prefix('/pages')->group(function () {
            Route::get('/', [PagesController::class, 'index']);
            Route::post('/store', [PagesController::class, 'store']);
            Route::get('/edit/{id}', [PagesController::class, 'edit']);
            Route::put('/update/{id}', [PagesController::class, 'update']);
            Route::delete('/delete/{id}', [PagesController::class, 'destroy']);
            Route::get('/get-all-countries', [PagesController::class, 'getAllCountries']);
        });

        //ProductReview
        Route::prefix('/product-review')->group(function () {
            Route::get('/', [ProductReviewController::class, 'index']);
            Route::post('/store', [ProductReviewController::class, 'store']);
            Route::get('/edit/{id}', [ProductReviewController::class, 'edit']);
            Route::post('/update/{id}', [ProductReviewController::class, 'update']);
            Route::delete('/delete/{id}', [ProductReviewController::class, 'destroy']);
            Route::get('/get-all-products', [ProductReviewController::class, 'getAllProducts']);
        });

        //Orders
        Route::prefix('/orders')->group(function () {
            Route::get('/', [OrdersController::class, 'index']);
            Route::get('/cod-list', [OrdersController::class, 'CODList']);
            Route::post('/book', [OrdersController::class, 'bookOrder']);
            Route::post('/book/status', [OrdersController::class, 'bookedOrderStatus']);
            Route::post('/delete/{id}', [OrdersController::class, 'deleteOrder']);
        });

        //Customers
        Route::prefix('/customers')->group(function () {
            Route::get('/', [CustomersController::class, 'index']);
        });
    });
});
