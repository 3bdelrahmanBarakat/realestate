<?php

namespace App\Http\Controllers\API\V1\Properties;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Property\Action\StoreRequest;
use App\Http\Resources\API\V1\Property\PropertyActionResource;
use App\Interfaces\PropertyActionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyActionController extends Controller
{
    use APIResponse;

    public function __construct(public PropertyActionInterface $PropertyActionInterface)
    {
    }

    public function index()
    {
        $property_actions = $this->PropertyActionInterface->index();


        return $this->success(200, "products", PropertyActionResource::collection($property_actions), [
            'current_page' => $property_actions->currentPage(),
            'total_pages' => $property_actions->lastPage(),
            'per_page' => $property_actions->perPage(),
            'total' => $property_actions->total(),
        ]);
    }

    public function all()
    {
        $property_actions = $this->PropertyActionInterface->all();
        return $this->success(200, "property_actions", PropertyActionResource::collection($property_actions));
    }

    public function me()
    {
        $property_actions = $this->PropertyActionInterface->me();
        return $this->success(200, "property_actions", PropertyActionResource::collection($property_actions));
    }


    public function store(StoreRequest $request): JsonResponse
    {
        $property_action = $this->PropertyActionInterface->store($request->validated());
        return $this->success(201, "Property action created successfully", PropertyActionResource::make($property_action));
    }

    public function delete(int|string $id): JsonResponse
    {
        $this->PropertyActionInterface->delete($id);
        return $this->success(202, "Property action deleted successfully", []);
    }

}
