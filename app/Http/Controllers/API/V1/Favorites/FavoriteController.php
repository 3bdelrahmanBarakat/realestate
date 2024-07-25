<?php

namespace App\Http\Controllers\API\V1\Favorites;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Favorite\FavoritePopularResource;
use App\Http\Resources\API\V1\Favorite\FavoriteResource;
use App\Interfaces\FavoriteInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use APIResponse;

    public function __construct(public FavoriteInterface $FavoriteInterface)
    {
    }

    public function index(Request $request)
    {
        $favorites = $this->FavoriteInterface->index($request);
        return $this->success(200, "favorites", FavoriteResource::collection($favorites), [
            'current_page' => $favorites->currentPage(),
            'total_pages' => $favorites->lastPage(),
            'per_page' => $favorites->perPage(),
            'total' => $favorites->total(),
        ]);
    }

    public function all()
    {
        $favorites = $this->FavoriteInterface->all();
        return $this->success(200, "favorites", FavoriteResource::collection($favorites));
    }


    public function popularProperties()
    {
        $favorites = $this->FavoriteInterface->popularProperties();
        return $this->success(200, "favorites", FavoritePopularResource::collection($favorites));
    }


    public function toggle(int|string $id): JsonResponse
    {
        $result = $this->FavoriteInterface->toggle($id);

        if ($result['status'] === 'removed') {
            return $this->success(200, "Property removed from favorites successfully", []);
        }

        return $this->success(201, "Property added to favorites successfully", FavoriteResource::make($result['favorite']));
    }

    public function delete(int|string $id): JsonResponse
    {
        $this->FavoriteInterface->delete($id);
        return $this->success(202, "Property deleted from favorite successfully", []);
    }
}
