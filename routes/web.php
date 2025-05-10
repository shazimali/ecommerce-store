<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubCategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');

Route::get('categories/{slug}', [CategoriesController::class, 'subCategoriesByCategorySlug'])->name('categories');
Route::get('sub-categories/{slug}', [SubCategoriesController::class, 'productsBySubCategorySlug'])->name('sub-categories');
Route::get('products/{slug}', [ProductsController::class, 'detail'])->name('product.detail');
Route::get('shop', [ProductsController::class, 'shop'])->name('shop');
Route::get('blogs', [BlogsController::class, 'index'])->name('blogs.index');
Route::get('blogs/{slug}', [BlogsController::class, 'detail'])->name('blogs.detail');
Route::get('pages/{slug}', [PagesController::class, 'index'])->name('pages.index');
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth.basic');

Route::get('contact-page', [ContactController::class, 'index'])->name('contact.page');
