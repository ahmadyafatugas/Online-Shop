<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Products;
use App\Models\User;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleHandle()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('email', $user->email)->first();
            if (!$findUser) {
                $findUser = User::create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'password' => Hash::make($user->password)
                ]);
            }
            Auth::login($findUser);
            return redirect()->intended('/');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function index()
    {
        return Inertia::render("daftar");
    }

    public function daftar(UserRequest $request): JsonResponse
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

        return (new UserResource($user))->response()->setStatusCode(201);
    }


    public function login()
    {
        return Inertia::render("login");
    }

    public function loginStore(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "email or password wrong"
                    ]
                ]
            ], 401));
        }
        Auth::login($user);
        return new UserResource($user);
    }


    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        return redirect("/");
    }

    public function user()
    {
        $user = Auth::user();
        return response()->json($user);
    }
}
