<?php

namespace App\Http\Controllers\API\Auth\Admin;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\UpdateNotificationPreferences;
use App\Http\Requests\API\V1\Auth\UpdateAdminProfileRequest;
use App\Http\Requests\API\V1\Auth\UploadProfileImageRequest;
use App\Http\Resources\API\V1\Admin\AdminResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    use APIResponse, ImageUploader;

    public function update(UpdateAdminProfileRequest $request)
    {
        $request->user()->fill($request->validated());

        if($request->has('image')){

            $image = $this->uploadImage($request, 'image', "public/uploads/admins/profile");

        if ($request->user()->image) {

            Storage::delete("public/uploads/admins/profile/{$request->user()->image}");

        }

            $request->user()->image = $image;
        }

        $request->user()->save();

        return $this->success(202, "updated successfully", AdminResource::make($request->user()));
    }



    public function show(Request $request)
    {
        return $this->success(200, "success", AdminResource::make($request->user()));
    }

}
