<?php

use App\Models\Color;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

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

Route::get('/', [AdminController::class, "login"])->name("admin.login");
Route::post('admin/auth', [AdminController::class, "auth"])->name("admin.auth");

Route::prefix("admin")->middleware("admin")->group(function () {
    Route::get('dashboard', [AdminController::class, "index"])->name("admin.index");
    Route::post('logout', [AdminController::class, "logout"])->name("admin.logout");
    //Categories Route
    Route::resource("categories", CategoryController::class, [
        'names' => [
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',

        ]
    ]);
    //Brands Route
    Route::resource("brands", BrandController::class, [
        'names' => [
            'index' => 'admin.brands.index',
            'create' => 'admin.brands.create',
            'store' => 'admin.brands.store',
            'edit' => 'admin.brands.edit',
            'update' => 'admin.brands.update',
            'destroy' => 'admin.brands.destroy',

        ]
    ]);

    //Colors Route
    Route::resource("colors", ColorController::class, [
        'names' => [
            'index' => 'admin.colors.index',
            'create' => 'admin.colors.create',
            'store' => 'admin.colors.store',
            'edit' => 'admin.colors.edit',
            'update' => 'admin.colors.update',
            'destroy' => 'admin.colors.destroy',

        ]
    ]);

    //Sizes Route
    Route::resource("sizes", SizeController::class, [
        'names' => [
            'index' => 'admin.sizes.index',
            'create' => 'admin.sizes.create',
            'store' => 'admin.sizes.store',
            'edit' => 'admin.sizes.edit',
            'update' => 'admin.sizes.update',
            'destroy' => 'admin.sizes.destroy',

        ]
    ]);

    //Product Route
    Route::resource("products", ProductController::class, [
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',

        ]
    ]);

    //Coupon Route
    Route::resource("coupons", CouponController::class, [
        'names' => [
            'index' => 'admin.coupons.index',
            'create' => 'admin.coupons.create',
            'store' => 'admin.coupons.store',
            'edit' => 'admin.coupons.edit',
            'update' => 'admin.coupons.update',
            'destroy' => 'admin.coupons.destroy',

        ]
    ]);

    //Orders Route
    Route::get('orders', [OrderController::class, "index"])->name("admin.orders.index");
    Route::get('update/{order}/order', [OrderController::class, "updateDeliveredAtDate"])->name("admin.orders.update");
    Route::delete('delete/{order}/order', [OrderController::class, "delete"])->name("admin.orders.delete");

    //Reviews Route
    Route::get('reviews', [ReviewController::class, "index"])->name("admin.reviews.index");
    Route::get('update/{review}/{status}/review', [ReviewController::class, "toggleApproveStatus"])->name("admin.reviews.update");
    Route::delete('delete/{review}/review', [ReviewController::class, "delete"])->name("admin.reviews.delete");

    //users routes
    Route::get('users', [UserController::class, "index"])->name("admin.users.index");
    Route::delete('delete/{user}/user', [UserController::class, "delete"])->name("admin.users.delete");
});
