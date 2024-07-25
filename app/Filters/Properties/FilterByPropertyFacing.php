<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByPropertyFacing
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $property_facing = $this->request->get('property_facing');

        return $next($builder)->when(
            $property_facing,
            function ($query) use ($property_facing) {
                if (!empty($property_facing)) {
                    $query->where("property_facing", "like", "%" . $property_facing . "%");
                }
            }
        );
    }
}
