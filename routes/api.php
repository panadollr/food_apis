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
Route::get('products-of-category/{category_slug}', [UserProductController::class, 'getProductsByCategorySlug']);
Route::get('similiar-products/{product_id}', [UserProductController::class, 'getSimiliarProducts']);
Route::get('product/{product_id}', [UserProductController::class, 'getProductDetails']);
Route::get('product-details', [UserProductController::class, 'getProductDetails']);
Route::get('search-products', [UserProductController::class, 'searchProducts']);
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::post('submit-referral-code', [UserOrderController::class, 'submitReferralCode']);
Route::post('order', [UserOrderController::class, 'order']);




//ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminSlideController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;

Route::prefix('admin')->middleware('cors')->group(function () {
Route::get('general-information', [DashboardController::class, 'generalInformation']);
Route::get('slides', [AdminSlideController::class, 'getSlides']);
Route::get('top-categories', [DashboardController::class, 'topCategories']);
Route::get('top-products', [DashboardController::class, 'topProducts']);
Route::get('news', [AdminNewsController::class, 'getNews']);
Route::post('add-news', [AdminNewsController::class, 'addNews']);
Route::post('update-news', [AdminNewsController::class, 'updateNews']);
Route::get('categories', [AdminCategoryController::class, 'getCategories']);
Route::post('add-category', [AdminCategoryController::class, 'addCategory']);
Route::delete('delete-category/{category_id}', [AdminCategoryController::class, 'deleteCategory']);
Route::get('products', [AdminProductController::class, 'getProducts']);
Route::get('product/{product_id}', [AdminProductController::class, 'getProductDetails']);
Route::get('search-products', [AdminProductController::class, 'searchProducts']);
Route::post('add-product', [AdminProductController::class, 'addProduct']);
Route::delete('delete-product/{product_id}', [AdminProductController::class, 'deleteProduct']);
Route::post('update-product', [AdminProductController::class, 'updateProduct']);
Route::get('orders', [AdminOrderController::class, 'getOrders']);
Route::get('order-details/{order_id}', [AdminOrderController::class, 'getOrderDetails']);
Route::post('update-order-status', [AdminOrderController::class, 'updateOrderStatus']);
});


Route::get('welcome', function () {
    return 'hello vercel with laravel';
});
