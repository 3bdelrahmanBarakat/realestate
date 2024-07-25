<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByToiletsNum
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $toilets_num = $this->request->get('toilets_num');

        return $next($builder)->when(
            $toilets_num,
            function ($query) use ($toilets_num) {
                $query->whereHas('features', function ($query) use ($toilets_num) {
                    $query->where('toilets_num', $toilets_num);
                });
            }
        );
    }
}
