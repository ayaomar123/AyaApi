<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:admin']], function () {
//    Route::get('/me', function(Request $request) {
//        return auth()->user();
//    });

    Route::delete('category', [CategoryController::class, 'destroy']);
    Route::resource('category', CategoryController::class);

    Route::delete('items', [ItemController::class, 'destroy']);
    Route::resource('items', ItemController::class);

    Route::delete('carts', [CartController::class, 'destroy']);
    Route::resource('carts', CartController::class);

    Route::delete('cartItems', [CartItemController::class, 'destroy']);
    Route::resource('cartItems', CartItemController::class);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});





