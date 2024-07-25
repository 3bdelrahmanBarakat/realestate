<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByPurpose
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $purpose = $this->request->get('purpose');

        return $next($builder)->when(
            $purpose,
            function ($query) use ($purpose) {
                if (!empty($purpose)) {
                    $query->where("purpose", "like", "%" . $purpose . "%");
                }
            }
        );
    }
}
