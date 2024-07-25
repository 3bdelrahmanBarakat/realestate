<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByBedroomsNum
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $bedrooms_num = $this->request->get('bedrooms_num');

        return $next($builder)->when(
            $bedrooms_num,
            function ($query) use ($bedrooms_num) {
                $query->whereHas('features', function ($query) use ($bedrooms_num) {
                    $query->where('bedrooms_num', $bedrooms_num);
                });
            }
        );
    }
}
