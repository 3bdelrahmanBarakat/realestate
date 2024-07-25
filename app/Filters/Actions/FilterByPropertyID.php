<?php
namespace App\Filters\Actions;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByPropertyID
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $property_id = $this->request->get('property_id');

        return $next($builder)->when(
            $property_id,
            function ($query) use ($property_id) {
                if (!empty($property_id)) {
                    $query->where("property_id",$property_id);
                }
            }
        );
    }
}
