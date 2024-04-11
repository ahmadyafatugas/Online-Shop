<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Products;
use App\Models\OrderItem;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use App\Http\Requests\SellerRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SellerResource;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\SellerProductUpdate;
use App\Http\Requests\SellerUpdateRequest;
use App\Http\Requests\SellerProductRequest;
use App\Http\Resources\SellerOrderResource;
use App\Http\Resources\ProductSellerResource;

class SellerController extends Controller
{
    private function getSeller($id)
    {
        $seller = Seller::where('user_id', $id)->first();
        return $seller->id;
    }

    private function getProductId($idSeller, $idProduct)
    {
        $product = Products::where('id', $idProduct)->where('seller_id', $idSeller)->first();
        return $product;
    }

    public function create(SellerRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('seller-image');
        }
        $seller = new Seller($data);
        $seller->user_id = Auth::id();
        $seller->save();
        return (new SellerResource($seller))->response()->setStatusCode(201);
    }

    public function get()
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        return new SellerResource($seller);
    }

    public function update(SellerUpdateRequest $request)
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        $data = $request->validated();
        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store('seller-image');
            if ($seller->image) {
                Storage::delete($seller->image);
            }
        }
        $seller->fill($data);
        $seller->save();
        return (new SellerResource($seller))->response()->setStatusCode(201);
    }

    public function getProduct(Request $request)
    {
        $sort_field = $request->input('sort_field', 'created_at');
        $validatorField = ['created_at'];
        if (!in_array($sort_field, $validatorField)) {
            $sort_field = 'created_at';
        }
        $sort_direction = $request->input('sort_direction', 'asc');
        $validatorDirection = ['asc', 'desc'];
        if (!in_array($sort_direction, $validatorDirection)) {
            $sort_direction = 'desc';
        }
        $seller = $this->getSeller(Auth::id());
        $category = $request->input('category');
        $productQuery = Products::where('seller_id', $seller);
        if ($category) {
            $productQuery->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            });
        }
        $product = $productQuery->orderBy($sort_field, $sort_direction)->get();
        return (ProductSellerResource::collection($product))->response()->setStatusCode(200);
    }


    public function singleProductSeller(int $id)
    {
        $product = Products::where('id', $id)->first();
        return (new ProductResource($product))->response()->setStatusCode(200);
    }

    public function createProduct(SellerProductRequest $request)
    {
        $seller = $this->getSeller(Auth::id());
        $data = $request->validated();
        if ($request->hasFile('url')) {
            $data['url'] = $request->file('url')->store('post-image');
        }
        $product = new Products($data);
        $product->seller_id = $seller;
        $product->save();

        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    public function updateProduct(SellerProductUpdate $request, int $id)
    {
        $product = Products::where('id', $id)->first();
        $data = $request->validated();
        if ($request->file('url')) {
            $data['url'] = $request->file('url')->store('post-image');
            Storage::delete($product->url);
        }
        $product->fill($data);
        $product->save();
        return (new ProductResource($product))->response()->setStatusCode(200);
    }

    public function deleteProduct(int $id)
    {
        $seller = $this->getSeller(Auth::id());
        $product = $this->getProductId($seller, $id);
        CartProduct::where('product_id', $id)->delete();
        OrderItem::where('product_id', $id)->delete();
        if ($product->url) {
            Storage::delete($product->url);
        }
        $product->delete();
        return response()->json([
            'message' => 'product deleted'
        ])->setStatusCode(200);
    }

    public function searchProduct(Request $request)
    {
        $seller = $this->getSeller(Auth::id());
        $search = $request->input('search');
        if ($search) {
            $product = Products::where('seller_id', $seller)->where("title", "ilike", "%" . $search . "%")->get();
            return response()->json([
                'data' => $product
            ]);
        } else {
            return response()->json(['message' => 'Tidak ada permintaan pencarian.']);
        }
    }

    public function getSellerCategoryProduct()
    {
        $seller = $this->getSeller(Auth::id());
        $products = Products::where('seller_id', $seller)->get();
        return (ProductResource::collection($products))->response()->setStatusCode(200);
    }

    public function getOrderSeller()
    {
        $seller = $this->getSeller(Auth::id());
        $order = OrderItem::where('seller_id', $seller)->get();
        return (SellerOrderResource::collection($order))->response()->setStatusCode(200);
    }

    public function getSellerFromUser(Request $request, $id)
    {
        $seller = Seller::where('id', $id)->first();
        return (new SellerResource($seller))->response()->setStatusCode(200);
    }

    public function shopSeller($shop)
    {
        $seller = Seller::where('shop', $shop)->first();
        return Inertia::render('Shop', ['id' => $seller->id, 'name' => $seller->name, 'address' => $seller->address, 'image' => $seller->image]);
    }

    public function getProductSellerFromUser(Request $request, $id)
    {
        $sort_field = $request->input('sort_field', 'price');
        $validatorField = ['price'];
        if (!in_array($sort_field, $validatorField)) {
            $sort_field = 'price';
        }
        $sort_direction = $request->input('sort_direction', 'asc');
        $validatorDirection = ['asc', 'desc'];
        if (!in_array($sort_direction, $validatorDirection)) {
            $sort_direction = 'asc';
        }
        $category = $request->input('category');
        $seller = Seller::where('id', $id)->first();
        $productQuery = Products::where('seller_id', $seller->id);
        if ($category) {
            $productQuery->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            });
        }
        $products = $productQuery->orderBy($sort_field, $sort_direction)->get();
        return (ProductResource::collection($products))->response()->setStatusCode(200);
    }

    public function getCategoryProduct($id)
    {
        $seller = Seller::where('id', $id)->first();
        $products = Products::where('seller_id', $seller->id)->get();
        $categories = $products->pluck('category')->unique();
        return (CategoryResource::collection($categories))->response()->setStatusCode(200);
    }

    public function home()
    {
        return Inertia::render('seller/home');
    }

    public function sellerProduct()
    {
        return Inertia::render('seller/productSeller');
    }

    public function createProductView()
    {
        $category = Category::all();
        return Inertia::render('seller/createProduct', ['category' => $category]);
    }

    public function editProductView($id)
    {
        $product = Products::where('id', $id)->first();
        $category = Category::all();
        return Inertia::render('seller/editProduct', ['product' => $product, 'category' => $category]);
    }

    public function orderSellerView()
    {
        return Inertia::render('seller/OrderSeller');
    }

    public function orderSellerSetting()
    {
        return Inertia::render('seller/SellerSetting');
    }

    public function registerSeller()
    {
        return Inertia::render('registerSeller');
    }
}
