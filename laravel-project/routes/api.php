<?php

use App\Models\Review;
use Illuminate\Http\Request;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ProductController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return [
            'user' => UserResource::make($request->user()),
            'access_token' => $request->bearerToken()
        ];
    });
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::put('user/update/profile', [UserController::class, 'UpdateUserProfile']);

    //Coupons Route
    Route::post('apply/coupon', [CouponController::class, 'applyCoupon']);

    //Orders Route
    Route::post('store/order', [OrderController::class, 'storeUserOrders']);
    Route::post('pay/order', [OrderController::class, 'payOrdersByStripe']);

    //Review Route
    Route::post('store/review', [ReviewController::class, 'store']);
    Route::put('update/review', [ReviewController::class, 'update']);
    Route::post('delete/review', [ReviewController::class, 'delete']);
});



/**
 * Products Route
 */

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{category}/category', [ProductController::class, 'filterProductByCategory']);
Route::get('products/{brand}/brand', [ProductController::class, 'filterProductByBrand']);
Route::get('products/{color}/color', [ProductController::class, 'filterProductByColor']);
Route::get('products/{size}/size', [ProductController::class, 'filterProductBySize']);
Route::get('products/{searchTerm}/find', [ProductController::class, 'filterProductByTerm']);
Route::get('products/{product}/show', [ProductController::class, 'show']);


/**
 * User Route
 */
Route::post('user/register', [UserController::class, 'Store']);
Route::post('user/login', [UserController::class, 'auth']);
