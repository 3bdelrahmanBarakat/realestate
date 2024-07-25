<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByRoomsNum
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $rooms_num = $this->request->get('rooms_num');

        return $next($builder)->when(
            $rooms_num,
            function ($query) use ($rooms_num) {
                $query->whereHas('features', function ($query) use ($rooms_num) {
                    $query->where('rooms_num', $rooms_num);
                });
            }
        );
    }
}
