<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/register', [ProductController::class, 'create'])->name('products.register');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::post('/products/upload-temp', [ProductController::class, 'uploadTempImage'])->name('products.uploadTemp');
Route::get('/products/detail/{id}', [ProductController::class, 'show'])->name('products.detail');
Route::put('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.destroy');