<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;

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
// Proctected Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/products', [ProductsController::class, 'store']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/{id}', [ProductsController::class, 'destroy']);
    Route::post('/logout', [UsersController::class, 'logout']);
});

// Public Routes
Route::get('/products/search/{name}', [ProductsController::class, 'search']);
Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
