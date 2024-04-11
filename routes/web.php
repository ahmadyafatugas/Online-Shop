<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login and Register
Route::get('/', [ProductController::class, 'home'])->name("home");
Route::get('/daftar', [AuthController::class, 'index'])->name("daftar");
Route::get('/masuk', [AuthController::class, 'login'])->name('masuk');
// User
Route::get('/product/{id}', [ProductController::class, 'singleProduct'])->name("product");
Route::get('/product/category/{name}', [ProductController::class, 'productByCategory'])->name('productCategory');
Route::get('/shop/{shop}', [SellerController::class, 'shopSeller'])->name('shop');
Route::get('/shoppingcart', [UserController::class, 'shoppingCart'])->name("shoppingcart");
Route::get("/order", [OrderController::class, 'orderView'])->name("order");
Route::get('/address', [AddressController::class, 'viewAddress'])->name("address");
Route::get("/success", [UserController::class, 'success']);
Route::get('/checkout', [OrderController::class, 'checkout'])->name("checkout");
//seller
Route::get('/seller', [SellerController::class, 'home'])->name("seller");
Route::get('/seller/product', [SellerController::class, 'sellerProduct'])->name("sellerProduct");
Route::get('/seller/product/create', [SellerController::class, 'createProductView'])->name("createProduct");
Route::get('/seller/product/edit/{id}', [SellerController::class, 'editProductView'])->name("editProduct");
Route::get('/seller/order', [SellerController::class, 'orderSellerView'])->name("orderSeller");
Route::get('/seller/setting', [SellerController::class, 'orderSellerSetting'])->name("sellerSetting");
Route::get('/seller/register', [SellerController::class, 'registerSeller'])->name("sellerRegister");
//admin
Route::get('/admin/user', [AdminController::class, 'adminView'])->name('adminUser');
Route::get('/admin/user/edit/{id}', [AdminController::class, 'adminEditView'])->name('adminEdit');
Route::get('/admin/seller', [AdminController::class, 'adminSellersView'])->name('adminSeller');
Route::get('/admin/seller/edit/{id}', [AdminController::class, 'adminEditSeller'])->name('adminEditSeller');
Route::get('/admin/category', [AdminController::class, 'adminCategoryView'])->name('adminCategory');
Route::get('/admin/category/create', [AdminController::class, 'adminAddCategory'])->name('adminCreateCategory');
require __DIR__ . '/auth.php';
