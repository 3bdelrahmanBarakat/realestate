<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByAreaRange
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $area_from = $this->request->get('area_from');
        $area_to = $this->request->get('area_to');

        return $next($builder)->when(
            $area_from && $area_to,
            function ($query) use ($area_from, $area_to) {
                $query->whereBetween('area', [$area_from, $area_to]);
            }
        );
    }
}
