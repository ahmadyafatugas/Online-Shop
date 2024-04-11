<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Admin;
use App\Models\Orders;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Products;
use App\Models\Addresses;
use App\Models\OrderItem;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdminResource;
use App\Http\Requests\AdminUpdateUser;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdminUpdateSeller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\InfoUserForAdmin;
use App\Http\Resources\infoSellerForAdmin;
use App\Models\InfoUsers;

class AdminController extends Controller
{

    public function admin()
    {
        $user = Auth::user();
        if (Admin::where('user_id', $user->id)->first()) {
            return new AdminResource($user);
        } else {
            return response()->json([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ])->setStatusCode(401);
        }
    }

    public function user()
    {
        $user = InfoUsers::all();
        return(InfoUserForAdmin::collection($user))->response()->setStatusCode(200);
    }

    public function singleUser($id)
    {
        $user = InfoUsers::where('user_id', $id)->first();
        return(new InfoUserForAdmin($user))->response()->setStatusCode(200);
    }

    public function updateUser(AdminUpdateUser $request, int $id)
    {
        $user = User::where('id', $id)->first();
        $data = $request->validated();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();
        return(new UserResource($user))->response()->setStatusCode(201);
    }

    public function deleteUser(int $id)
    {
        $seller = Seller::where('user_id', $id)->first();
        if ($seller) {
            $product = Products::where('seller_id', $seller->id)->get();
            $orderItem = OrderItem::where('seller_id', $seller->id)->first();
            if ($orderItem) {
                $orderItem->delete();
            }
            if ($product) {
                foreach ($product as $p) {
                    Storage::delete($p->url);
                    $p->delete();
                }
                ;
            }
            $seller->delete();
        }
        InfoUsers::where('user_id', $id)->delete();
        Cart::where('user_id', $id)->delete();
        Orders::where('user_id', $id)->delete();
        Addresses::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
        return response()->json([
            "message" => "user deleted"
        ])->setStatusCode(200);
    }

    public function seller()
    {
        $seller = Seller::with(['user'])->get();
        return(infoSellerForAdmin::collection($seller))->response()->setStatusCode(200);
    }

    public function singleSeller($id)
    {
        $seller = Seller::where('id', $id)->first();
        return(new infoSellerForAdmin($seller))->response()->setStatusCode(200);
    }

    public function updateSeller(AdminUpdateSeller $request, int $id)
    {
        $seller = Seller::where('id', $id)->first();
        $data = $request->validated();
        $seller->fill($data);
        $seller->save();
        return(new infoSellerForAdmin($seller))->response()->setStatusCode(201);
    }

    public function deleteSeller(int $id)
    {
        $seller = Seller::where('id', $id);
        $product = Products::where('seller_id', $id)->get();
        foreach ($product as $p) {
            $cartProduct = CartProduct::where('product_id', $p->id);
            $Order = OrderItem::where('product_id', $p->id);
            $cartProduct->delete();
            $Order->delete();
            Storage::delete($p->url);
            $p->delete();
        }
        $seller->delete();
        return response()->json([
            "message" => "Seller deleted"
        ])->setStatusCode(200);
    }

    public function createCategory(CategoryRequest $request)
    {
        $data = $request->validated();
        $category = new Category($data);
        $category->save();
        return(new CategoryResource($category))->response()->setStatusCode(201);
    }

    public function deleteCategory(int $id)
    {
        $category = Category::where('id', $id)->first();
        $category->delete();
        return response()->json([
            'message' => 'category deleted'
        ])->setStatusCode(200);
    }

    public function adminView()
    {
        return Inertia::render('admin/infoUsers');
    }

    public function adminEditView($id)
    {
        $user = User::where('id', $id)->first();
        return Inertia::render('admin/editUser', ['user' => $user]);
    }

    public function adminSellersView()
    {
        return Inertia::render('admin/infoSellers');
    }

    public function adminEditSeller($id)
    {
        $seller = Seller::where('id', $id)->first();
        return Inertia::render('admin/editSeller', ['seller' => $seller]);
    }

    public function adminCategoryView()
    {
        $category = Category::all();
        return Inertia::render('admin/infoCategory', ['category' => $category]);
    }

    public function adminAddCategory()
    {
        return Inertia::render('admin/addCategory');
    }
}
