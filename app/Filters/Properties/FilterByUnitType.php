<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByUnitType
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $unit_type = $this->request->get('unit_type');

        return $next($builder)->when(
            $unit_type,
            function ($query) use ($unit_type) {
                if (!empty($unit_type)) {
                    $query->where("unit_type", "like", "%" . $unit_type . "%");
                }
            }
        );
    }
}
