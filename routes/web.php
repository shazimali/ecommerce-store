<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubCategoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('categories/{slug}', [CategoriesController::class, 'subCategoriesByCategorySlug'])->name('categories');
Route::get('sub-categories/{slug}', [SubCategoriesController::class, 'productsBySubCategorySlug'])->name('sub-categories');
Route::get('products/{slug}', [ProductsController::class, 'detail'])->name('product.detail');
Route::get('cart', [CartController::class, 'index'])->name('cart');
