<?php
namespace App\Filters\Properties\Listings;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByAdminID
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
                    $query->where("admin_id", $user_id);
                }
            }
        );
    }
}
