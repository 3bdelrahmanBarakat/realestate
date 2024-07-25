<?php

namespace App\Http\Controllers\API\V1\Users;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\User\Table\UserPropertiesTableResource;
use App\Http\Resources\API\V1\User\Table\UserTableResource;
use App\Interfaces\UserInterface;

class UserController extends Controller
{
    use APIResponse;

    public function __construct(public UserInterface $UserInterface)
    {
    }

    public function usersTable()
    {
        $users= $this->UserInterface->usersTable();
        return $this->success(200, "users", UserTableResource::collection($users), [
            'current_page' => $users->currentPage(),
            'total_pages' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
        ]);
    }

    public function userPropertiesTable($userId)
    {
        $userProperties = $this->UserInterface->userPropertiesTable($userId);

    return $this->success(200, "user properties", new UserPropertiesTableResource($userProperties), [
        'current_page' => $userProperties['properties']->currentPage(),
        'total_pages' => $userProperties['properties']->lastPage(),
        'per_page' => $userProperties['properties']->perPage(),
        'total' => $userProperties['properties']->total(),
    ]);
    }

}
