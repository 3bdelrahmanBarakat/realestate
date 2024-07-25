<?php

namespace App\Http\Controllers\API\V1\Owners;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Owner\OwnerResource;
use App\Http\Resources\API\V1\Property\PropertyResource;
use App\Interfaces\OwnerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    use APIResponse;

    public function __construct(public OwnerInterface $OwnerInterface)
    {
    }

    public function index()
    {
        $properties = $this->OwnerInterface->index();


        return $this->success(200, "Owners", OwnerResource::collection($properties), [
            'current_page' => $properties->currentPage(),
            'total_pages' => $properties->lastPage(),
            'per_page' => $properties->perPage(),
            'total' => $properties->total(),
        ]);
    }

    public function all()
    {
        $properties = $this->OwnerInterface->all();
        return $this->success(200, "Owners", OwnerResource::collection($properties));
    }

    public function show(int|string $id)
    {
        $property = $this->OwnerInterface->show($id);
        return $this->success(200, "Owner", OwnerResource::make($property));
    }

    public function delete(int|string $id): JsonResponse
    {
        $this->OwnerInterface->delete($id);
        return $this->success(202, "Owner deleted successfully", []);
    }

}
