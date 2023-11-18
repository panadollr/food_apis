<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//USER
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserCategoryController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\UserOrderController;

Route::get('categories', [UserCategoryController::class, 'getCategories']);
Route::get('products', [UserProductController::class, 'getProducts']);
Route::get('search-products', [UserProductController::class, 'searchProducts']);
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::post('submit-referral-code', [UserOrderController::class, 'submitReferralCode']);
Route::post('order', [UserOrderController::class, 'order']);




//ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::prefix('admin')->middleware('cors')->group(function () {
Route::get('general-information', [DashboardController::class, 'generalInformation']);
Route::get('top-categories', [DashboardController::class, 'topCategories']);
Route::get('top-products', [DashboardController::class, 'topProducts']);
Route::get('news', [AdminNewsController::class, 'getNews']);
Route::get('add-news', [AdminNewsController::class, 'addNews']);
Route::get('categories', [AdminCategoryController::class, 'getCategories']);
Route::post('add-category', [AdminCategoryController::class, 'addCategory']);
Route::get('products', [AdminProductController::class, 'getProducts']);
Route::post('add-product', [AdminProductController::class, 'addProduct']);
Route::delete('delete-product/{product_id}', [AdminProductController::class, 'deleteProduct']);
Route::get('orders', [AdminOrderController::class, 'getOrders']);
Route::post('update-order-status', [AdminOrderController::class, 'updateOrderStatus']);
});


Route::get('welcome', function () {
    return 'hello vercel with laravel';
});
