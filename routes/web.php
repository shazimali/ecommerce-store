<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\SubCategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('categories/{slug}', [CategoriesController::class, 'subCategoriesByCategorySlug'])->name('categories');
Route::get('sub-categories/{slug}', [SubCategoriesController::class, 'productsBySubCategorySlug'])->name('sub-categories');
Route::get('products/{slug}', [ProductsController::class, 'detail'])->name('product.detail');
Route::get('shop', [ProductsController::class, 'shop'])->name('shop');
Route::get('blogs', [BlogsController::class, 'index'])->name('blogs.index');
Route::get('blogs/{slug}', [BlogsController::class, 'detail'])->name('blogs.detail');
Route::get('pages/{slug}', [PagesController::class, 'index'])->name('pages.index');
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('order/{id}', [CheckoutController::class, 'orderDetail'])->name('checkout.order-detail');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth.basic');

Route::get('contact-us', [ContactUsController::class, 'index'])->name('contact_us');
Route::post('contact-us', [ContactUsController::class, 'sendEmail'])->name('contact_us.post');

Route::middleware('guest')->group(function () {
    // ...
    Route::get('social/{provider}/redirect', [SocialAuthController::class, 'loginSocial'])
        ->name('social.auth');

    Route::get('social/{provider}/callback', [SocialAuthController::class, 'callbackSocial'])
        ->name('social.callback');

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
});
