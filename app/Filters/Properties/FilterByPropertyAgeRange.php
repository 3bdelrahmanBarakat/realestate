<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByPropertyAgeRange
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $property_age_from = $this->request->get('property_age_from');
        $property_age_to = $this->request->get('property_age_to');

        return $next($builder)->when(
            $property_age_from && $property_age_to,
            function ($query) use ($property_age_from, $property_age_to) {
                $query->whereBetween('property_age', [$property_age_from, $property_age_to]);
            }
        );
    }
}
