<?php

namespace App\Http\Controllers\API\V1\Properties;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Property\HideRequest;
use App\Http\Requests\API\V1\Property\StoreRequest;
use App\Http\Requests\API\V1\Property\UpdateRequest;
use App\Http\Resources\API\V1\Property\HiddenPropertyResource;
use App\Http\Resources\API\V1\Property\PropertyResource;
use App\Interfaces\PropertyInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    use APIResponse;

    public function __construct(public PropertyInterface $PropertyInterface)
    {
    }

    public function index()
    {

        $properties = $this->PropertyInterface->index();


        return $this->success(200, "properties", PropertyResource::collection($properties), [
            'current_page' => $properties->currentPage(),
            'total_pages' => $properties->lastPage(),
            'per_page' => $properties->perPage(),
            'total' => $properties->total(),
        ]);
    }

    public function all(Request $request)
    {
        $properties = $this->PropertyInterface->all($request->all());
        return $this->success(200, "properties", PropertyResource::collection($properties));
    }

    public function show(int|string $id)
    {
        $property = $this->PropertyInterface->show($id);
        return $this->success(200, "property", PropertyResource::make($property));
    }

    public function update(UpdateRequest $request, int|string $id): JsonResponse
    {
        $property = $this->PropertyInterface->update($request->validated(), $id);
        return $this->success(202, "Property updated successfully", PropertyResource::make($property));
    }


    public function store(StoreRequest $request): JsonResponse
    {
        $property = $this->PropertyInterface->store($request->validated());
        return $this->success(201, "Property created successfully", PropertyResource::make($property));
    }

    public function delete(int|string $id): JsonResponse
    {
        $this->PropertyInterface->delete($id);
        return $this->success(202, "Property deleted successfully", []);
    }

    public function hiddenProperties(): JsonResponse
    {
       $hiddenProperties = $this->PropertyInterface->hiddenProperties();
        return $this->success(202, "hidden properties", HiddenPropertyResource::collection($hiddenProperties),[
            'current_page' => $hiddenProperties->currentPage(),
            'total_pages' => $hiddenProperties->lastPage(),
            'per_page' => $hiddenProperties->perPage(),
            'total' => $hiddenProperties->total(),
        ]);
    }

    public function hideProperty(HideRequest $request, int|string $id): JsonResponse
    {
       $this->PropertyInterface->hideProperty($request->validated(), $id);
        return $this->success(202, "Property Hid successfully", []);
    }


}
