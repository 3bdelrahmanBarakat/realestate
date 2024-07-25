<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByCity
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $city = $this->request->get('city');

        return $next($builder)->when(
            $city,
            function ($query) use ($city) {
                if (!empty($city)) {
                    $query->where("city", "like", "%" . $city . "%");
                }
            }
        );
    }
}
