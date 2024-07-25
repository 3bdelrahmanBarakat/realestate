<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByStatus
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $status = $this->request->get('status');

        return $next($builder)->when(
            $status,
            function ($query) use ($status) {
                if (!empty($status)) {
                    $query->where("status", "like", "%" . $status . "%");
                }
            }
        );
    }
}
