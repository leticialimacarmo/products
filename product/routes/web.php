<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/itensClient', [ClientController::class, 'getClient']);
Route::post('/registerClient', [ClientController::class, 'registerClient']);
Route::post('/updateClient', [ClientController::class, 'updateClient']);
Route::delete('/deleteClient/{id}', [ClientController::class, 'deleteClient']);

Route::post('/getProducts', [ProductController::class, 'getProducts'])->name('getProducts');
Route::post('/registerProduct', [ProductController::class, 'registerProduct'])->name('registerProduct');
Route::post('/updateProduct', [ProductController::class, 'updateProduct'])->name('updateProduct');
Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');

Route::post('/getList', [ListController::class, 'getList'])->name('getList');

Route::post('/getClientSales', [SalesController::class, 'getClientSales'])->name('getClientSales');

Route::post('/registerSales', [SalesController::class, 'registerSales'])->name('registerSales');

Route::post('/updateList', [ListController::class, 'updateList'])->name('updateList');
Route::delete('/deleteList', [ListController::class, 'deleteList'])->name('deleteList');
