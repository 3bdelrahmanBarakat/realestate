<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByDescription
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $description = $this->request->get('description');

        return $next($builder)->when(
            $description,
            function ($query) use ($description) {
                if (!empty($description)) {
                    $query->where("description", "like", "%" . $description . "%");
                }
            }
        );
    }
}
