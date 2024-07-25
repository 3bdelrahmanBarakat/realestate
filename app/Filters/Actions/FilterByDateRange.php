<?php
namespace App\Filters\Actions;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByDateRange
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $start_date = $this->request->get('start_date');
        $end_date = $this->request->get('end_date');

        return $next($builder)->when(
            $start_date && $end_date,
            function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        );
    }
}
