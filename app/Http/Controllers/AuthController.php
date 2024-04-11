<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdminResource;
use App\Http\Requests\UserLoginRequest;
use App\Models\InfoUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function register(UserRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (User::where('email', $data['email'])->count() == 1) {
            throw new HttpResponseException(response([
                "errors" => [
                    "email" => [
                        "email already registered"
                    ]
                ]
            ], 400));
        }
        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();
        InfoUsers::create([
            'user_id' => $user->id
        ]);
        return(new UserResource($user))->response()->setStatusCode(201);
    }

    public function loginStore(UserLoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user || !password_verify($data['password'], $user->password)) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "email or password wrong"
                    ]
                ]
            ], 401));
        }
        Auth::login($user);
        $admin = Admin::where('user_id', $user->id)->first();
        $token = JWTAuth::fromUser($user);
        if ($admin) {
            $token = JWTAuth::fromUser($user);
            return(new AdminResource($user))->additional(['token' => $token]);
        } else {
            $token = JWTAuth::fromUser($user);
            return(new UserResource($user))->additional(['token' => $token]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'User Logout'
        ]);
    }

    public function index()
    {
        return Inertia::render("daftar");
    }

    public function login()
    {
        return Inertia::render("login");
    }
}
