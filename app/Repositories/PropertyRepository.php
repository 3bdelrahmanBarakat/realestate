<?php

namespace App\Repositories;

use App\Filters\Properties\FilterByAmenities;
use App\Filters\Properties\FilterByAreaRange;
use App\Filters\Properties\FilterByBedroomsNum;
use App\Filters\Properties\FilterByBoolean;
use App\Filters\Properties\FilterByCity;
use App\Filters\Properties\FilterByDescription;
use App\Filters\Properties\FilterByDistinctiveAddress;
use App\Filters\Properties\FilterByDistrict;
use App\Filters\Properties\FilterByFloorRange;
use App\Filters\Properties\FilterByLivingRoomsNum;
use App\Filters\Properties\FilterByMarketerName;
use App\Filters\Properties\FilterByPriceRange;
use App\Filters\Properties\FilterByPropertyAgeRange;
use App\Filters\Properties\FilterByPropertyFacing;
use App\Filters\Properties\FilterByPurpose;
use App\Filters\Properties\FilterByRoomsNum;
use App\Filters\Properties\FilterByStatus;
use App\Filters\Properties\FilterByToiletsNum;
use App\Filters\Properties\FilterByType;
use App\Filters\Properties\FilterByUnitType;
use App\Filters\Properties\FilterByUser;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Interfaces\PropertyInterface;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\CommercialLandDetail;
use App\Models\HiddenProperty;
use App\Models\OtherPropertyDetail;
use App\Models\OtherPropertyFeature;
use App\Models\Owner;
use App\Models\PropertyAmenity;
use App\Services\PropertyService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\DB;

class PropertyRepository implements PropertyInterface
{
    use APIResponse, ImageUploader;

    public function __construct(protected PropertyService $PropertyService)
    {
    }

    public function index()
    {
    $query = Property::query()->orderBy('created_at', 'desc');


    if (!auth()->check() || (auth()->check() && auth()->user()->role === 'user')) {
        $query->where('status', 'pending');
    }

    $properties = Pipeline::send($query)
        ->through([
            FilterByMarketerName::class,
            FilterByDistinctiveAddress::class,
            FilterByCity::class,
            FilterByDistrict::class,
            FilterByPurpose::class,
            FilterByType::class,
            FilterByStatus::class,
            FilterByUnitType::class,
            FilterByAreaRange::class,
            FilterByToiletsNum::class,
            FilterByRoomsNum::class,
            FilterByBedroomsNum::class,
            FilterByLivingRoomsNum::class,
            FilterByFloorRange::class,
            FilterByPropertyAgeRange::class,
            FilterByPropertyFacing::class,
            FilterByDescription::class,
            FilterByBoolean::class,
            FilterByAmenities::class,
            FilterByUser::class,
        ])
        ->thenReturn()
        ->paginate(10)
        ->withQueryString();


        $properties->load(['images', 'features', 'otherFeatures', 'rentalDetail', 'otherDetails', 'amenities', 'owner']);

        if ((auth()->check() && auth()->user()->role === 'superadmin') || (auth()->check() && auth()->user()->role === 'admin')) {
            foreach ($properties as $property) {
                $actions = $property->actions ?? collect();
                $property->action_counts = [
                    'called' => $actions->where('action', 'called')->count(),
                    'sent_message' => $actions->where('action', 'sent_message')->count(),
                    'whatsapp' => $actions->where('action', 'whatsapp')->count(),
                    'viewed' => $actions->where('action', 'viewed')->count(),
                ];
            }

            $sort_by_action = request()->query('sort_by_action', null);
            $sort_order = request()->query('sort_order', 'asc');

            if ($sort_by_action) {
                $properties = $properties->sortBy(function ($property) use ($sort_by_action) {
                    return $property->action_counts[$sort_by_action] ?? 0;
                }, SORT_REGULAR, $sort_order === 'desc');
            }

        }
        $this->PropertyService->checkIfFavourite($properties,null);
    return $properties;
    }

    public function all(array $data)
    {

        $query = Pipeline::send(Property::query())
            ->through([
                FilterByMarketerName::class,
                FilterByDistinctiveAddress::class,
                FilterByCity::class,
                FilterByDistrict::class,
                FilterByPurpose::class,
                FilterByType::class,
                FilterByUnitType::class,
                FilterByAreaRange::class,
                FilterByToiletsNum::class,
                FilterByRoomsNum::class,
                FilterByBedroomsNum::class,
                FilterByLivingRoomsNum::class,
                FilterByFloorRange::class,
                FilterByPriceRange::class,
                FilterByPropertyAgeRange::class,
                FilterByPropertyFacing::class,
                FilterByDescription::class,
                FilterByBoolean::class,
                FilterByAmenities::class,
                FilterByUser::class,
            ])
            ->thenReturn();

            if (isset($data['num'])) {
                $query->limit($data['num']);
            }

            $properties = $query->get();

        $properties->load(['images', 'features', 'otherFeatures', 'rentalDetail', 'otherDetails', 'amenities', 'owner']);
        return $properties;
    }

    public function show(int|string $id)
    {
        $property = $this->find($id);
        $property->load(['images', 'features', 'otherFeatures', 'rentalDetail', 'otherDetails', 'amenities', 'owner']);
        $this->PropertyService->checkIfFavourite(null,$property);
        return $property;
    }

    public function hiddenProperties()
    {
    $query = HiddenProperty::query()->orderBy('created_at', 'desc');

    $properties = Pipeline::send($query)
        ->through([])
        ->thenReturn()
        ->paginate(10)
        ->withQueryString();

        $properties->load(['property.images']);

    return $properties;
    }

    public function hideProperty(array $data,int|string $id)
    {
        $property = $this->find($id);
        $property->status = 'Hidden';
        $property->save();
        $property->hiddenProperties()->create($data);
    }

    public function update(array $data, int|string $id): Property
    {
        $property = $this->find($id);

        DB::transaction(function () use ($data, $property) {
            $property->update($data);

            //delete one of existing images
            if (isset($data['image_id'])) {
                $image = $property->images()->find($data['image_id']);
                $this->removeImage("public/uploads/properties", $image->image);
                $image->delete();
            }

            // Add new images
            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image' => $this->uploadImage($image, 'image', 'public/uploads/properties')
                    ]);
                }
            }

            // Update other attachment
            if (isset($data['other_attachment'])) {
                $this->removeImage("public/uploads/properties/attachments", $property->other_attachment);
                $property->other_attachment = $this->uploadImage($data['other_attachment'], 'other_attachment', 'public/uploads/properties/attachments');
                $property->save();
            }

            // Update property features
            if (isset($data['features'])) {
                $property->features()->updateOrCreate([], $data['features']);
            }

            // Update property other details
            if (isset($data['other_details'])) {
                foreach ($data['other_details'] as $detail) {
                    OtherPropertyDetail::updateOrCreate([
                        'property_id' => $property->id,
                        'detail' => $detail['detail']
                    ]);
                }
            }


            // Update property amenitites
            if (isset($data['amenities'])) {
                foreach ($data['amenities'] as $amenity) {
                    PropertyAmenity::updateOrCreate([
                        'property_id' => $property->id,
                        'amenity' => $amenity['amenity']
                    ]);
                }
            }

            // Update other features
            if (isset($data['other_features'])) {
                foreach ($data['other_features'] as $feature) {
                    OtherPropertyFeature::updateOrCreate([
                        'property_id' => $property->id,
                        'feature' => $feature['feature']
                    ]);
                }
            }

            // Update rental details if the property is for rent
            if ($property->type === 'for rent' && isset($data['rentalDetail'])) {
                $property->rentalDetail()->updateOrCreate([], ['rental_type' => $data['rental_type']]);
            }

            // Update commercial land details if the property is a commercial land
            // if ($property->purpose === 'commercial' && isset($data['commercialLandDetail'])) {
            //     $property->commercialLandDetail()->updateOrCreate([], $data['commercialLandDetail']);
            // }
        });

        $property->load(['images', 'rentalDetail', 'features','otherFeatures', 'otherDetails', 'amenities', 'owner']);
        return $property;
    }

    public function store(array $data): Property
    {
        $property = DB::transaction(function () use ($data) {

            $data['admin_id'] = Auth::id();
            $data['marketer_name'] = auth()->user()->name;

            if (isset($data['owner_id'])) {
                $owner= Owner::findOrFail($data['owner_id']);
            }
            else{
                    $owner = Owner::create([
                        'name' => $data['owner_name'],
                        'phone' => $data['owner_phone'],
                    ]);
                }
                $data['owner_id'] = $owner->id;
                $data['owner_name'] = $owner->name;
                $data['owner_phone'] = $owner->phone;


            // Create main property
            $property = Property::create($data);

            // Add images
            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image' => $this->uploadMultipleImages($image, 'public/uploads/properties')
                    ]);
                }
            }

            // Add other attachment
            if (isset($data['other_attachment'])) {
                $property->other_attachment = $this->uploadMultipleImages($data['other_attachment'], 'public/uploads/properties/attachments');
                $property->save();
            }

            // Add property features
            if (isset($data['features'])) {
                $property->features()->create($data['features']);
            }

            // Add property other details
            if (isset($data['other_details'])) {
                foreach ($data['other_details'] as $detail) {
                    OtherPropertyDetail::create([
                        'property_id' => $property->id,
                        'detail' => $detail
                    ]);
                }
            }

            //add property amenities
            if (isset($data['amenities'])) {
                foreach ($data['amenities'] as $amenity) {
                    PropertyAmenity::create([
                        'property_id' => $property->id,
                        'amenity' => $amenity
                    ]);
                }
            }

             // Add other features
             if (isset($data['other_features'])) {
                foreach ($data['other_features'] as $feature) {
                    OtherPropertyFeature::create([
                        'property_id' => $property->id,
                        'feature' => $feature
                    ]);
                }
            }

            // Add rental details if the property is for rent
            if ($property->type === 'for rent' && isset($data['rental_type'])) {
                $property->rentalDetail()->create(['rental_type' => $data['rental_type']]);
            }

            // Add commercial land details if the property is a commercial land
            // if ($property->purpose === 'commercial' && isset($data['commercialLandDetail'])) {
            //     $property->commercialLandDetail()->create($data['commercialLandDetail']);
            // }

            return $property;
        });

        $property->load(['images', 'rentalDetail', 'features', 'otherFeatures', 'otherDetails', 'amenities', 'owner']);
        return $property;
    }

    public function delete(int|string $id): void
    {
        $property = $this->find($id);

        DB::transaction(function () use ($property) {
            // Remove images
            foreach ($property->images as $image) {
                $this->removeImage("public/uploads/properties", $image->image);
                $image->delete();
            }

            if ($property->other_attachment) {
                $this->removeImage("public/uploads/properties/attachments", $property->other_attachment);
            }

            // Delete boolean attributes
            if ($property->features) {
                $property->features()->delete();
            }

            // Delete other features
            if($property->otherFeatures){
                $property->otherFeatures()->delete();
            }

            //delete other details
            if($property->otherDetails()){
                $property->otherDetails()->delete();
            }

            //delete other details
            if($property->amenities()){
                $property->amenities()->delete();
            }

            // Delete rental detail
            if ($property->rentalDetail()) {
                $property->rentalDetail()->delete();
            }

            // Delete commercial land detail
            // if ($property->commercialLandDetail) {
            //     $property->commercialLandDetail()->delete();
            // }

            // Delete property
            $property->delete();
        });
    }

    public function find(int|string $id): Property
    {
        $property = Property::where("id", $id)->first();

        if (!$property) {
            throw new HttpResponseException($this->error(404, "There is no property with the given id:{$id}", []));
        }
        $property->load(['images', 'features', 'otherFeatures', 'rentalDetail', 'otherDetails', 'amenities', 'owner']);
        return $property;
    }
}
