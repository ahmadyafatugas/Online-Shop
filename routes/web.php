<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [ItemController::class, 'home'])->name("home");
Route::get("/signin", [UserController::class, 'googleLogin'])->name('googleLogin');
Route::get("/auth/google/callback", [UserController::class, 'googleHandle']);
Route::get('/daftar', [UserController::class, 'index'])->name("daftar");
Route::post('/daftar', [UserController::class, 'daftar']);
Route::get('/masuk', [UserController::class, 'login'])->name('masuk');
Route::post('/masuk', [UserController::class, 'loginStore']);
Route::post("/logout", [UserController::class, 'logout'])->name("logout");
Route::get("/search", [ItemController::class, 'search']);


Route::middleware(['auth'])->group(function () {
    Route::get("/user", [UserController::class, 'user']);
    Route::get('/item/{id}', [ItemController::class, 'index'])->name("item");
    Route::get('/shoppingcart', [ItemController::class, 'shoppingCart'])->name("shoppingcart");
    Route::get('/checkout', [ItemController::class, 'checkout'])->name("checkout");
    Route::post('/checkoutS', [ItemController::class, 'checkoutStore']);
    Route::get('/address', [ItemController::class, 'address'])->name("address");
    Route::post('/address', [ItemController::class, 'addressStore']);
    Route::put('/address/{id}', [ItemController::class, 'updateAddress']);
    Route::get("/success", [ItemController::class, 'success']);
    Route::get("/order", [ItemController::class, 'orderView'])->name("order");
    Route::post("/order", [ItemController::class, 'order']);
});
require __DIR__ . '/auth.php';
