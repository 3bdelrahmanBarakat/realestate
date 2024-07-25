<?php

namespace App\Repositories;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Interfaces\PropertyActionInterface;
use App\Models\PropertyAction;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\DB;

class PropertyActionRepository implements PropertyActionInterface
{
    use APIResponse;

    public function index()
    {
        $property_actions = Pipeline::send(PropertyAction::query())
            ->through([])
            ->thenReturn()
            ->paginate(10)
            ->withQueryString();

        $property_actions->load(['property', 'user', 'admin']);
        return $property_actions;
    }

    public function all()
    {
        $property_actions = Pipeline::send(PropertyAction::query())
            ->through([])
            ->thenReturn()
            ->get();
        $property_actions->load(['property', 'user', 'admin']);
        return $property_actions;
    }

    public function me()
    {
        $query = Pipeline::send(PropertyAction::query())
            ->through([])
            ->thenReturn();

            if (isset($data['num'])) {
                $query->limit($data['num']);
            }

            if(auth()->user()->role == "admin")
            {
                $query->where('admin_id', Auth::id());
            } else
            {
                $query->where('user_id', Auth::id());
            }

        $property_actions = $query->get();

        $property_actions->load(['property', 'user', 'admin']);
        return $property_actions;
    }


    public function store(array $data): PropertyAction
    {
        $property_action = DB::transaction(function () use ($data) {

            $data['admin_id'] = Auth::id();

            $property_action = PropertyAction::create($data);


            return $property_action;
        });

        $property_action->load(['property', 'user', 'admin']);
        return $property_action;
    }

    public function delete(int|string $id): void
    {
        $property_action = $this->find($id);

        DB::transaction(function () use ($property_action) {

            $property_action->delete();
        });
    }

    public function find(int|string $id): PropertyAction
    {
        $property_action = PropertyAction::where("id", $id)->first();

        if (!$property_action) {
            throw new HttpResponseException($this->error(404, "There is no property action with the given id:{$id}", []));
        }
        $property_action->load(['property', 'user', 'admin']);
        return $property_action;
    }

}
