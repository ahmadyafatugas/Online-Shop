<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Admin;
use App\Models\Orders;
use App\Models\Seller;
use App\Models\Products;
use App\Models\Addresses;
use App\Models\OrderItem;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CartRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\AdminResource;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserUpdateRequest;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\ProductCartResource;
use App\Http\Resources\ProductOrderResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, int $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            throw new HttpResponseException(response()->json([
                'error' => [
                    'message' => [
                        'User Not Found'
                    ]
                ]
            ]));
        }
        $data = $request->validated();
        $user->fill($data);
        $user->save();
        return new UserResource($user);
    }

    public function cart(CartRequest $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $user->id
            ]);
        }
        $data = $request->validated();
        CartProduct::create([
            'cart_id' => $cart->id,
            'product_id' => $data['product_id']
        ]);
        return response()->json([
            'message' => 'add to cart'
        ])->setStatusCode(200);
    }

    public function getCart()
    {
        $user = Auth::user();
        $cartId = Cart::where('user_id', $user->id)->first();
        $product = CartProduct::where('cart_id', $cartId->id)->with(['product'])->get();
        if (!CartProduct::where('cart_id', $cartId->id)->first()) {
            return response()->json([
                'message' => 'no product in cart'
            ])->setStatusCode(204);
        } else {
            return (ProductCartResource::collection($product))->response()->setStatusCode(200);
        }
    }

    public function deleteCart($id)
    {
        $cartId = Cart::where('user_id', Auth::id())->first();
        $cart = $cartId->cart()->where("product_id", $id)->first();
        $cart->delete();
        return response()->json([
            'message' => 'product deleted'
        ])->setStatusCode(201);
    }

    public function shoppingCart()
    {
        $user = Auth::user();
        return Inertia::render('shoppingcart', ['user' => $user]);
    }

    public function success()
    {
        return Inertia::render("success");
    }
}
