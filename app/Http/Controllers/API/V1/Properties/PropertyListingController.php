<?php

namespace App\Http\Controllers\API\V1\Properties;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Property\Listing\StoreRequest;
use App\Http\Requests\API\V1\Property\Listing\UpdateRequest;
use App\Http\Resources\API\V1\Property\ListingResource;
use App\Interfaces\PropertyListingInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyListingController extends Controller
{
    use APIResponse;

    public function __construct(public PropertyListingInterface $PropertyListingInterface)
    {
    }

    public function index()
    {
        $property_listings = $this->PropertyListingInterface->index();


        return $this->success(200, "property_listings", ListingResource::collection($property_listings), [
            'current_page' => $property_listings->currentPage(),
            'total_pages' => $property_listings->lastPage(),
            'per_page' => $property_listings->perPage(),
            'total' => $property_listings->total(),
        ]);
    }

    public function all(Request $request)
    {
        $property_listings = $this->PropertyListingInterface->all($request->all());
        return $this->success(200, "property_listings", ListingResource::collection($property_listings));
    }

    public function me()
    {
        $property_listings = $this->PropertyListingInterface->me();
        return $this->success(200, "property_listings", ListingResource::collection($property_listings), [
            'current_page' => $property_listings->currentPage(),
            'total_pages' => $property_listings->lastPage(),
            'per_page' => $property_listings->perPage(),
            'total' => $property_listings->total(),
        ]);
    }

    public function show(int|string $id)
    {
        $property_listing = $this->PropertyListingInterface->show($id);
        return $this->success(200, "property_listing", ListingResource::make($property_listing));
    }

    public function update(UpdateRequest $request, int|string $id): JsonResponse
    {
        $property_listing = $this->PropertyListingInterface->update($request->validated(), $id);
        return $this->success(202, "Property Listing updated successfully", ListingResource::make($property_listing));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $property_listing = $this->PropertyListingInterface->store($request->validated());
        return $this->success(201, "Property Listing created successfully", ListingResource::make($property_listing));
    }

    public function delete(int|string $id): JsonResponse
    {
        $this->PropertyListingInterface->delete($id);
        return $this->success(202, "Property Listing deleted successfully", []);
    }
}
