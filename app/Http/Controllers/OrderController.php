<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Orders;
use Stripe\StripeClient;
use App\Models\Addresses;
use App\Models\OrderItem;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\ProductOrderResource;


class OrderController extends Controller
{
    public function checkout()
    {
        $stripeSecretKey = env('STRIPE_KEY');
        return Inertia::render('checkout', ['secretKey' => $stripeSecretKey]);
    }

    public function order(OrderRequest $request)
    {
        $user = Auth::user();
        $cartId = Cart::where('user_id', $user->id)->first();
        $data = $request->validated();
        $address = Addresses::where('user_id', $user->id)->first();
        $order = Orders::where('user_id', $user->id)->first();
        if (!$order) {
            $order = Orders::create([
                'user_id' => $user->id,
                'address_id' => $address->id
            ]);
        }
        foreach ($data['products'] as $prod) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $prod['id'],
                'seller_id' => $prod['seller_id']
            ]);

            $cart = CartProduct::where('cart_id', $cartId->id)->where('product_id', $prod['id'])->first();
            if ($cart) {
                $cart->delete();
            }
        }
        return response()->json([
            'berhasil'
        ])->setStatusCode(200);
    }

    public function getOrder()
    {
        $user = Auth::user();
        $order = Orders::where('user_id', $user->id)->first();
        $product = OrderItem::where('order_id', $order->id)->with(['product'])->get();
        if (!OrderItem::where('order_id', $order->id)->first()) {
            response()->json([
                'message' => 'no orders'
            ])->setStatusCode(400);
        } else {
            return (ProductOrderResource::collection($product))->response()->setStatusCode(200);
        }

    }

    public function payment(PaymentRequest $request)
    {
        $stripeSecretKey = env('STRIPE_SECRET');
        $stripe = new StripeClient($stripeSecretKey);
        $intent = $stripe->paymentIntents->create([
            'amount' => $request->total,
            'currency' => 'idr',
            'payment_method_types' => ['card'],
        ]);
        return $intent;
    }

    public function orderView()
    {
        return Inertia::render('order');
    }
}
