<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['cors'])->group(function () {
    Route::get('/home', [Controllers\HomeController::class, 'index']);
    
    Route::get('/product', [Controllers\ProductController::class, 'index']);
    Route::get('/product_search', [Controllers\ProductController::class, 'show']);
    Route::post('/product_new', [Controllers\ProductController::class, 'store']);
    Route::post('/product_edit', [Controllers\ProductController::class, 'edit']);
    Route::post('/product_delete', [Controllers\ProductController::class, 'destroy']);
    
    Route::get('/sale', [Controllers\SaleController::class, 'index']);
    Route::get('/sale_search', [Controllers\SaleController::class, 'show']);
    Route::post('/sale_new', [Controllers\SaleController::class, 'store']);
    Route::post('/sale_edit', [Controllers\SaleController::class, 'edit']);
    Route::post('/sale_delete', [Controllers\SaleController::class, 'destroy']);
    Route::get('/sale_products_services', [Controllers\SaleController::class, 'get_products_services']);
    
    Route::get('/service', [Controllers\ServiceController::class, 'index']);
    Route::get('/service_search', [Controllers\ServiceController::class, 'show']);
    Route::post('/service_new', [Controllers\ServiceController::class, 'store']);
    Route::post('/service_edit', [Controllers\ServiceController::class, 'edit']);
    Route::post('/service_delete', [Controllers\ServiceController::class, 'destroy']);
});