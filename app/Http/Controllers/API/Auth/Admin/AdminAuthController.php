<?php

namespace App\Http\Controllers\API\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Requests\API\V1\Auth\LoginAdminRequest;
use App\Http\Resources\API\V1\Admin\AdminResource;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminAuthController extends Controller
{
    use APIResponse;

    public function login(LoginAdminRequest $request)
    {
        return $this->authenticate($request);
    }

    public function user(Request $request)
    {
        return $this->success(200, "user success", ['user' => AdminResource::make($request->user())]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->success(200, "user logout success", []);
    }



    private function authenticate($request)
    {
        $this->ensureIsNotRateLimited($request);

        $admin = User::where('email', $request->validated("email"))->first();

        if (!$admin || !Hash::check($request->validated("password"), $admin->password)) {
            RateLimiter::hit($this->throttleKey($request));
            throw new HttpResponseException($this->error(
                401,
                "Unauthorized",
                [
                    'email' => trans('auth.failed'),
                ]
            ));
        }

        RateLimiter::clear($this->throttleKey($request));

        $token = $admin->createToken("{$admin->email}")->plainTextToken;
        return $this->success(200, "login.success", [
            'token' => $token,
            'user' => AdminResource::make($admin)
        ]);
    }

    private function ensureIsNotRateLimited($request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw new HttpResponseException($this->error(
            429,
            "Too Many Requests",
            [
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ])
            ]
        ));
    }

    private function throttleKey($request): string
    {
        return Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
    }
}
