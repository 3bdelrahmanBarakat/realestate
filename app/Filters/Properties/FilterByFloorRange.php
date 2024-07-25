<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByFloorRange
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $floor_from = $this->request->get('floor_from');
        $floor_to = $this->request->get('floor_to');

        return $next($builder)->when(
            $floor_from && $floor_to,
            function ($query) use ($floor_from, $floor_to) {
                $query->whereBetween('floor', [$floor_from, $floor_to]);
            }
        );
    }
}
