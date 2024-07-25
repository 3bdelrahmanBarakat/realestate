<?php

namespace App\Services;

class PropertyService
{
    public function checkIfFavourite($properties,$property)
    {
        $user = auth()->user();

        if ($properties && $properties != null) {


            foreach ($properties as $property) {
                $property->isFavorited = $user ? $user->favorites()->where('property_id', $property->id)->exists() : false;
                $property->favoriteId = $user ? $user->favorites()->where('property_id', $property->id)->value('id') : null;
            }
        }

        if ($property && $property != null) {

                $property->isFavorited = $user ? $user->favorites()->where('property_id', $property->id)->exists() : false;
                $property->favoriteId = $user ? $user->favorites()->where('property_id', $property->id)->value('id') : null;
        }
    }

}
