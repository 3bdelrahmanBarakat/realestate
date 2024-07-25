<?php


namespace App\Repositories;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Interfaces\FavoriteInterface;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;

class FavoriteRepository implements FavoriteInterface
{
    use APIResponse, ImageUploader;


    public function all()
    {
        $favorites = Pipeline::send(Favorite::query()->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc'))
            ->through([])
            ->thenReturn()
            ->get();

            $favorites->load('property.images', 'property.features' , 'property.amenities');

        return $favorites;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin' && $request->has('user_id')) {
            $userId = $request->input('user_id');
        } else {
            $userId = $user->id;
        }

        $favorites = Pipeline::send(Favorite::query()->where('user_id', $userId)->orderBy('created_at', 'desc'))
            ->through([])
            ->thenReturn()
            ->paginate(10)
            ->withQueryString();

        $favorites->load('property.images', 'property.features', 'property.amenities');

        return $favorites;
    }

    public function popularProperties()
    {
        $favorites = Favorite::select('property_id')
            ->groupBy('property_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->get();


            $favorites->load('property.images', 'property.features' , 'property.amenities');

            return $favorites;
    }


    public function toggle($id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);

        $favorite = Favorite::where('user_id', $user->id)->where('property_id', $property->id)->first();

        if ($favorite) {
            $favorite->delete();
            return ['status' => 'removed'];
        } else {
            $favorite = Favorite::create([
                "user_id" => $user->id,
                'property_id' => $property->id,
            ]);

            return ['status' => 'added', 'favorite' => $favorite];
        }
    }

    public function delete(int|string $id): void
    {
        $favorite = Favorite::where('user_id', auth()->user()->id)->findOrFail($id);
        $favorite->delete();
    }




}
