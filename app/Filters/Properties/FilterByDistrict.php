<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByDistrict
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $district = $this->request->get('district');

        return $next($builder)->when(
            $district,
            function ($query) use ($district) {
                if (!empty($district)) {
                    $query->where("district", "like", "%" . $district . "%");
                }
            }
        );
    }
}
