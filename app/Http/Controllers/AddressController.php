<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Addresses;
use App\Models\InfoUsers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Requests\AddressUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressController extends Controller
{
    public function address()
    {
        $user = Auth::id();
        $address = Addresses::where("user_id", $user)->first();
        return new AddressResource($address);
    }

    public function create(AddressRequest $request): JsonResponse
    {
        $userId = Auth::id();
        $data = $request->validated();
        $address = new Addresses($data);
        $address->user_id = $userId;
        $address->save();
        $InfoUser = InfoUsers::where('user_id', $userId)->first();
        $InfoUser->address_id = $address->id;
        $InfoUser->save();
        return(new AddressResource($address))->response()->setStatusCode(201);
    }

    public function update(int $id, AddressUpdateRequest $request): AddressResource
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

    public function viewAddress()
    {
        $user = Auth::id();
        $address = Addresses::where("user_id", $user)->first();
        return Inertia::render("address", ["address" => $address]);
    }
}
