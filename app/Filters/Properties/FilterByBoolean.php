<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByBoolean
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $booleans = ['in_building_or_villa','has_private_entrance', 'classification', 'has_board', 'has_floor_seating', 'has_masahb'];
        foreach ($booleans as $boolean) {
            $value = $this->request->get($boolean);
            $builder->when($value !== null, function ($query) use ($boolean, $value) {
                $query->whereHas('features', function ($query) use ($boolean,$value) {
                    $query->where($boolean, $value);
                });
            });
        }

        return $next($builder);
    }
}
