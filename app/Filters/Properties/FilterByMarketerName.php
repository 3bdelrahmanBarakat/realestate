<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByMarketerName
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $marketer_name = $this->request->get('marketer_name');

        return $next($builder)->when(
            $marketer_name,
            function ($query) use ($marketer_name) {
                if (!empty($marketer_name)) {
                    $query->where("marketer_name", "like", "%" . $marketer_name . "%");
                }
            }
        );
    }
}
