<?php
namespace App\Filters\Users;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByName
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $name = $this->request->get('name');

        return $next($builder)->when(
            $name,
            function ($query) use ($name) {
                if (!empty($name)) {
                    $query->where("name", "like", "%" . $name . "%");
                }
            }
        );
    }
}
