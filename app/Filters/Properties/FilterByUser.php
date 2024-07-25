<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByUser
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $user_name = $this->request->get('name');

        return $next($builder)->when(
            $user_name,
            function ($query) use ($user_name) {
                $query->whereHas('user', function ($query) use ($user_name) {
                    $query->where('name', "like", "%" . $user_name . "%");
                });
            }
        );
    }
}
