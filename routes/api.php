<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product', [ProductController::class, 'product']);
Route::get('/product/{id}', [ProductController::class, 'singleProductId']);
Route::get('/product/category/{name}', [ProductController::class, 'productCategory']);
Route::get("/seller/{id}", [SellerController::class, 'getSellerFromUser']);
Route::get("/seller/product/view/{id}", [SellerController::class, 'getProductSellerFromUser']);
Route::get("/seller/product/category/{id}", [SellerController::class, 'getCategoryProduct']);
Route::get("/search", [ProductController::class, 'search']);

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post("/register", [AuthController::class, 'register']);
    Route::post("/login", [AuthController::class, 'loginStore']);
});

Route::middleware(\App\Http\Middleware\ApiAuthMiddleware::class)->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile/{id}', [UserController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/user/cart', [UserController::class, 'cart']);
    Route::get('/user/cart', [UserController::class, 'getCart']);
    Route::delete('/user/cart/{id}', [UserController::class, 'deleteCart']);

    Route::post('/order', [OrderController::class, 'order']);
    Route::get('/order', [OrderController::class, 'getOrder']);
    Route::post('/payment', [OrderController::class, 'payment']);

    Route::post('/product/{id}', [UserController::class, 'available']);

    Route::get('/address', [AddressController::class, 'address']);
    Route::post('/address', [AddressController::class, 'create']);
    Route::put("/address/{id}", [AddressController::class, 'update']);

    Route::post("/seller", [SellerController::class, 'create']);
    Route::get("/seller", [SellerController::class, 'get']);
    Route::post("/seller/update", [SellerController::class, 'update']);
    Route::get('/seller/product/get', [SellerController::class, 'getProduct']);
    Route::get('/seller/product/search', [SellerController::class, 'searchProduct']);
    Route::get('/seller/product/get/{id}', [SellerController::class, 'singleProductSeller']);
    Route::get('/seller/category/get', [SellerController::class, 'getSellerCategoryProduct']);
    Route::post("/seller/product", [SellerController::class, 'createProduct']);
    Route::post("/seller/product/{id}", [SellerController::class, 'updateProduct']);
    Route::delete("/seller/product/{id}", [SellerController::class, 'deleteProduct']);
    Route::get("/seller/user/order", [SellerController::class, 'getOrderSeller']);
});

Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
    Route::get('/admin', [AdminController::class, 'admin']);
    Route::get('/admin/user', [AdminController::class, 'user']);
    Route::get('/admin/user/{id}', [AdminController::class, 'singleUser']);
    Route::put('/admin/user/{id}', [AdminController::class, 'updateUser']);
    Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser']);
    Route::get('/admin/seller', [AdminController::class, 'seller']);
    Route::get('/admin/seller/{id}', [AdminController::class, 'singleSeller']);
    Route::put('/admin/seller/{id}', [AdminController::class, 'updateSeller']);
    Route::delete('/admin/seller/{id}', [AdminController::class, 'deleteSeller']);
    Route::post('/admin/category', [AdminController::class, 'createCategory']);
    Route::delete('/admin/category/{id}', [AdminController::class, 'deleteCategory']);
});