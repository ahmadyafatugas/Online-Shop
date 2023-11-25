<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Orders;
use App\Models\payment;
use App\Models\Products;
use Stripe\StripeClient;
use App\Models\Addresses;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\ProductResource;
use App\Http\Requests\AddressUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ItemController extends Controller
{
    public function home()
    {
        $product = Products::all();
        return Inertia::render("Home", [
            'product' => $product,
        ]);
    }

    public function index(int $id)
    {
        $user = Auth::user();
        return Inertia::render("Item", ['product' => Products::Find($id), 'user' => $user]);
    }

    public function shoppingCart()
    {
        $user = Auth::user();
        return Inertia::render("shoppingcart", ['user' => $user]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::id();
        $address = Addresses::where("user_id", $user)->first();
        $payment = payment::where("user_id", $user)->first();
        $stripe = new StripeClient("sk_test_51OD3w5LWEb7cCr314Yf7yHVen3K6BS4pyreenIGQ9qaAQoZMrpxRLTFTioMgl2BPmX2qntaauNqxjlVPtvXE0hAt00pXruUwxQ");
        $intent = $stripe->paymentIntents->create([
            'amount' => 1000000,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);
        return Inertia::render("checkout", ['user' => $user, 'address' => $address, 'intent' => $intent]);
    }

    public function checkoutStore(Request $request)
    {
        $validate = new payment();
        $validate->user_id = auth()->user()->id;
        $validate->amount = $request->amount;
        $validate->save();
        return response()->json($validate);
    }

    public function address()
    {
        $user = Auth::id();
        $address = Addresses::where("user_id", $user)->first();
        return Inertia::render("address", ["address" => $address]);
    }

    public function addressStore(AddressRequest $request): JsonResponse
    {
        $userId = Auth::id();
        $data = $request->validated();
        $address = new Addresses($data);
        $address->user_id = $userId;
        $address->save();
        return (new AddressResource($address))->response()->setStatusCode(201);
    }

    public function updateAddress(int $id, AddressUpdateRequest $request): AddressResource
    {
        $user = Auth::id();
        $address = Addresses::where("id", $id)->where("user_id", $user)->first();
        if (!$address) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "not found"
                    ]
                ]
            ])->setStatusCode(404));
        }
        $data = $request->validated();
        $address->fill($data);
        $address->save();

        return new AddressResource($address);
    }


    public function orderView()
    {
        $id = Auth::id();
        $orders = Orders::where("user_id", $id)->get();
        $ordersWithItems = [];
        foreach ($orders as $order) {
            $items = OrderItem::where("order_id", $order->id)->with('product')->get();

            $orderData = [
                'order' => $order,
                'items' => $items->map(function ($item) {
                    return [
                        'url' => $item->product->url,
                        'title' => $item->product->title,
                    ];
                }),
            ];

            $ordersWithItems[] = $orderData;
        }
        return Inertia::render("order", ['orders' => $ordersWithItems]);
    }

    public function order(OrderRequest $request)
    {
        $id = Auth::id();
        $data = $request->validated();
        $order = Orders::create([
            'user_id' => $id,
            'name' => $data['name'],
            'address' => $data['address'],
            'zipcode' => $data['zipcode'],
            'city' => $data['city'],
            'country' => $data['country'],
        ]);

        foreach ($data['products'] as $prod) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => (int) $prod['id'],
            ]);
        }

        return response()->json($order, 201);
    }

    public function success()
    {
        return Inertia::render("success");
    }

    public function search(Request $request)
    {
        $search = $request->input("search");
        if ($search) {
            $products = Products::where("title", "ilike", "%" . $search . "%")->take(2)->get();
            return response()->json($products);
        } else {
            return response()->json(['message' => 'Tidak ada permintaan pencarian.']);
        }
    }

}
