<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByDistinctiveAddress
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $distinctive_address = $this->request->get('distinctive_address');

        return $next($builder)->when(
            $distinctive_address,
            function ($query) use ($distinctive_address) {
                if (!empty($distinctive_address)) {
                    $query->where("distinctive_address", "like", "%" . $distinctive_address . "%");
                }
            }
        );
    }
}
