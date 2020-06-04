<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'RegisterController');
        Route::post('login', 'LoginController');
        Route::post('logout', 'LogoutController')->middleware('auth:api');
    });
});

Route::apiResource('/products', 'ProductController');
Route::apiResource('/orders', 'OrderController');
Route::middleware('auth:api')->group(function () {
    Route::get('/cart-products', 'Controller@getCartProducts');
    Route::get('/order/{id}', 'Controller@getOrder');
    Route::post('/add-to-cart/{id}/{num}', 'Controller@addToCart');
    Route::post('/remove-from-cart/{id}', 'Controller@removeFromCart');
    Route::post('/create-order', 'Controller@createOrder');
});