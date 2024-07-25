<?php
namespace App\Filters\Users;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByPhone
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $phone = $this->request->get('phone');

        return $next($builder)->when(
            $phone,
            function ($query) use ($phone) {
                if (!empty($phone)) {
                    $query->where("phone", "like", "%" . $phone . "%");
                }
            }
        );
    }
}
