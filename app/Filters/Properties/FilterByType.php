<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByType
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $type = $this->request->get('type');

        return $next($builder)->when(
            $type,
            function ($query) use ($type) {
                if (!empty($type)) {
                    $query->where("type", "like", "%" . $type . "%");
                }
            }
        );
    }
}
