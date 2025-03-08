<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('categories/{slug}', [CategoriesController::class, 'SubCategoriesByCategorySlug'])->name('categories');
Route::get('products/{slug}', [ProductsController::class, 'detail'])->name('product.detail');
