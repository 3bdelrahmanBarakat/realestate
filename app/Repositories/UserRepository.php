<?php

namespace App\Repositories;

use App\Filters\Users\FilterByName;
use App\Filters\Users\FilterByPhone;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Http\Resources\API\V1\Property\PropertyResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    use APIResponse, ImageUploader;

    public function usersTable()
    {
        $users = Pipeline::send(User::query()->where('role', 'user'))
            ->through([
                FilterByName::class,
                FilterByPhone::class,
            ])
            ->thenReturn()
            ->select('users.id', 'users.name', 'users.phone', 'users.email', 'users.last_login_at')
            ->withCount(['actions as properties_count' => function ($query) {
                $query->distinct('property_id');
            }])
            ->paginate(10);

        return $users;
    }

    public function userPropertiesTable($userId)
{
    $user = User::with(['appointments.property', 'actions'])->where('role', 'user')->findOrFail($userId);

    $appointmentsQuery = Pipeline::send($user->appointments()->with('property')->getQuery())
        ->through([])
        ->thenReturn();

    $appointments = $appointmentsQuery->paginate(10);

    $propertiesWithAppointments = $appointments->map(function ($appointment) {
        return $appointment->property;
    })->unique('id');

    $actions = $user->actions->groupBy('property_id');

    $propertiesData = $propertiesWithAppointments->map(function ($property) use ($actions) {
        $propertyActions = $actions->get($property->id, collect());
        $property->load('images');
        return (object)[
            'called' => $propertyActions->where('action', 'called')->count(),
            'whatsapp' => $propertyActions->where('action', 'whatsapp')->count(),
            'sent_message' => $propertyActions->where('action', 'sent message')->count(),
            'viewed' => $propertyActions->where('action', 'viewed')->count(),
            'property' => $property,
        ];
    });

    $paginatedPropertiesData = $appointments->setCollection($propertiesData);

    $userData = [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'last_login_at' => $user->last_login_at,
    ];

    return [
        'user' => $userData,
        'properties' => $paginatedPropertiesData,
    ];
}



}
