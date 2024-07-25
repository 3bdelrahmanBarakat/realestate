<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByPriceRange
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $price_from = $this->request->get('price_from');
        $price_to = $this->request->get('price_to');

        return $next($builder)->when(
            $price_from && $price_to,
            function ($query) use ($price_from, $price_to) {
                $query->whereBetween('price', [$price_from, $price_to]);
            }
        );
    }
}
