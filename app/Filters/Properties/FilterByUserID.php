<?php
namespace App\Filters\Properties;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByUserID
{
    public function __construct(protected Request $request)
    {
    }

    public function handle(Builder $builder, Closure $next)
    {
        $user_id = $this->request->get('admin_id');

        return $next($builder)->when(
            $user_id,
            function ($query) use ($user_id) {
                if (!empty($user_id)) {
                    $query->where("user_id", $user_id );
                }
            }
        );
    }
}
