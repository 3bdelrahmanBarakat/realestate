<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByLivingRoomsNum
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $living_rooms_num = $this->request->get('living_rooms_num');

        return $next($builder)->when(
            $living_rooms_num,
            function ($query) use ($living_rooms_num) {
                $query->whereHas('features', function ($query) use ($living_rooms_num) {
                    $query->where('living_rooms_num', $living_rooms_num);
                });
            }
        );
    }
}
