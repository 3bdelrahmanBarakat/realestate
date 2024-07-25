<?php

namespace App\Http\Controllers\API\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Http\Resources\API\V1\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use APIResponse;


    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $user = $request->user();
        $user->update(['last_login_at' => now()]);

        $token = $request->user()->createToken("{$request->user()->email}")->plainTextToken;

        return $this->success(200, "login.success", [
            'token' => $token,
            'user' => UserResource::make($request->user())
        ]);
    }



    public function register(RegisterRequest $request)
    {

        $user = User::create([
            "name" => $request->validated('name'),
            "phone" => $request->validated('phone'),
            "email" => $request->validated('email'),
            "gender" => $request->validated('gender'),
            "role" => UserRole::CLIENT,
            'password' => Hash::make($request->validated('password')),
        ]);

        $token = $user->createToken("{$user->email}")->plainTextToken;

        return $this->success(200, "regiter success", [
            'token' => $token,
            'user' => UserResource::make($user)
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->success(200, "user logout success", []);
    }
}
