<?php

namespace App\Repositories;

use App\Filters\Properties\Listings\FilterByAdminID;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Interfaces\PropertyListingInterface;
use App\Models\Property;
use App\Models\PropertyListing;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\DB;

class PropertyListingRepository implements PropertyListingInterface
{
    use APIResponse, ImageUploader;

    public function index()
    {
        $property_listings = Pipeline::send(PropertyListing::query()->orderBy('created_at', 'desc'))
            ->through([
                FilterByAdminID::class
            ])
            ->thenReturn()
            ->paginate(10)
            ->withQueryString();
        $property_listings->load(['property','property.images','admin']);
        return $property_listings;
    }

    public function all(array $data)
    {

        $query = Pipeline::send(PropertyListing::query()->orderBy('created_at', 'desc'))
            ->through([
                FilterByAdminID::class
            ])
            ->thenReturn();

            if (isset($data['num'])) {
                $query->limit($data['num']);
            }

            $property_listings = $query->get();
            $property_listings->load(['property','property.images','admin']);
        return $property_listings;
    }

    public function me()
    {
        $property_listings = Pipeline::send(PropertyListing::query()
        ->where("admin_id", auth()->user()->id)
        ->orderBy('created_at', 'desc'))
            ->through([])
            ->thenReturn()
            ->paginate(10)
            ->withQueryString();

        $property_listings->load(['property','property.images','admin']);
        return $property_listings;
    }

    public function show(int|string $id)
    {
        $property_listing = $this->find($id);
        return $property_listing;
    }

    public function update(array $data, int|string $id): PropertyListing
    {
        $property_listing = $this->find($id);

        DB::transaction(function () use ($data, $property_listing) {
            $property_listing->update($data);
        });
        $property_listing->load(['property','property.images','admin']);
        return $property_listing;
    }

    public function store(array $data): PropertyListing
    {
        $property_listing = DB::transaction(function () use ($data) {

            $data['user_id'] = Auth::id();

            $property_listing = PropertyListing::create($data);
            $property = Property::find($property_listing->property_id);

            if($property->type == "for sale"){
                $property->update(['status' => 'sold']);
            }else{
                $property->update(['status' => 'rented']);
            }

            $property_listing->load(['property','admin']);
            return $property_listing;
        });

        return $property_listing;
    }

    public function delete(int|string $id): void
    {
        $property_listing = $this->find($id);

        DB::transaction(function () use ($property_listing) {
            $property_listing->delete();
        });
    }

    public function find(int|string $id): PropertyListing
    {
        $property_listing = PropertyListing::where("id", $id)->first();

        if (!$property_listing) {
            throw new HttpResponseException($this->error(404, "There is no property listing with the given id:{$id}", []));
        }
        $property_listing->load(['property','property.images','admin']);
        return $property_listing;
    }
}
