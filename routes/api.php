<?php

use App\Http\Controllers\Api\Admin\CustomerOrderController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\OrderItemController;
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

    Route::delete('category', [CategoryController::class, 'destroy']);
    Route::resource('category', CategoryController::class);

    Route::delete('items', [ItemController::class, 'destroy']);
    Route::resource('items', ItemController::class);

    Route::resource('customerOrder', CustomerOrderController::class);
    Route::patch('changeOrderStatus', [CustomerOrderController::class, 'changeOrderStatus']);
    Route::post('getOrderByStatus', [CustomerOrderController::class, 'getOrderByStatus']);





    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::post('/customer/register', [CustomerAuthController::class, 'register']);
Route::post('/customer/login', [CustomerAuthController::class, 'login']);

Route::group(['middleware' => ['auth:customers']], function () {
    Route::post('/customer/logout', [CustomerAuthController::class, 'logout']);
    Route::patch('/customer/updateProfile', [CustomerAuthController::class, 'updateProfile']);
    Route::patch('/customer/editPassword', [CustomerAuthController::class, 'editPassword']);

    Route::delete('carts', [CartController::class, 'destroy']);
    Route::resource('carts', CartController::class);

    Route::delete('cartItems', [CartItemController::class, 'destroy']);
    Route::resource('cartItems', CartItemController::class);

    Route::delete('orderItems', [OrderItemController::class, 'destroy']);
    Route::resource('orderItems', OrderItemController::class);
});



