<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByAmenities
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $amenity = $this->request->get('amenity');

        return $next($builder)->when(
            $amenity,
            function ($query) use ($amenity) {
                $query->whereHas('amenities', function ($query) use ($amenity) {
                    $query->where('amenity', $amenity);
                });
            }
        );
    }
}
