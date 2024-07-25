<?php

namespace App\Http\Controllers\API\Auth\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\AddAdminRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Http\Resources\API\V1\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use APIResponse;

    public function index()
    {
        $users = User::where('role', UserRole::ADMIN)->paginate(10);

        return $this->success(200, "success", [
            'users' => UserResource::collection($users)
        ]);
    }

    public function all()
    {
        $users = User::where('role', UserRole::ADMIN)->get();

        return $this->success(200, "success", [
            'users' => UserResource::collection($users)
        ]);
    }

    public function show($id)
    {
        $users = User::findOrFail($id);

        return $this->success(200, "success", [
            'users' => UserResource::make($users)
        ]);
    }

    public function showInfo()
    {
        $admin = Auth::user();

        return $this->success(200, "success", [
            'user' => UserResource::make($admin)
        ]);
    }

    public function store(AddAdminRequest $request)
    {
        $user = User::create([
            "name" => $request->validated('name'),
            "phone" => $request->validated('phone'),
            "email" => $request->validated('email'),
            "gender" => $request->validated('gender'),
            "role" => $request->validated('role'),
            'password' => Hash::make($request->validated('password')),
        ]);

        return $this->success(200, "regiter success", [
            'user' => UserResource::make($user)
        ]);
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->where('role', 'admin')->first();

        if (!$user) {
            return $this->error(404, "admin not found", []);
        }

        $user->delete();

        return $this->success(200, "admin deleted successfully", []);
    }
}
