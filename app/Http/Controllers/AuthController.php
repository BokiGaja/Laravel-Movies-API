<?php

namespace App\Http\Controllers;

use App\Http\Services\ValidationService;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request$request)
    {
        $validator = ValidationService::validateUser($request);
        if (!is_string($validator))
        {
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->password = bcrypt($request->password);
            $newUser->email = $request->email;
            $newUser->save();
        } else {
            return response()->json(['error' => $validator]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Wrong credentials']);
        }
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return "Successfully logged out";
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'acces_token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return \Auth::Guard('api');
    }
}
