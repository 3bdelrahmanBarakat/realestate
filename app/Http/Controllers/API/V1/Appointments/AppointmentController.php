<?php

namespace App\Http\Controllers\API\V1\Appointments;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Appointment\StoreRequest;
use App\Http\Requests\API\V1\Appointment\UpdateRequest;
use App\Http\Resources\API\V1\Appointment\AppointmentResource;
use App\Interfaces\AppointmentInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use APIResponse;

    public function __construct(public AppointmentInterface $AppointmentInterface)
    {
    }

    public function index()
    {
        $appointments = $this->AppointmentInterface->index();


        return $this->success(200, "appointments", AppointmentResource::collection($appointments), [
            'current_page' => $appointments->currentPage(),
            'total_pages' => $appointments->lastPage(),
            'per_page' => $appointments->perPage(),
            'total' => $appointments->total(),
        ]);
    }

    public function all()
    {
        $appointments = $this->AppointmentInterface->all();
        return $this->success(200, "appointments", AppointmentResource::collection($appointments));
    }

    public function me()
    {
        $appointments = $this->AppointmentInterface->me();
        return $this->success(200, "appointments", AppointmentResource::collection($appointments));
    }

    public function show(int|string $id)
    {
        $appointment = $this->AppointmentInterface->show($id);
        return $this->success(200, "appointment", AppointmentResource::make($appointment));
    }

    public function update(UpdateRequest $request, int|string $id): JsonResponse
    {
        $appointment = $this->AppointmentInterface->update($request->validated(), $id);
        return $this->success(202, "Appointment updated successfully", AppointmentResource::make($appointment));
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $appointment = $this->AppointmentInterface->store($request->validated());
        return $this->success(201, "Appointment created successfully", AppointmentResource::make($appointment));
    }

    public function delete(int|string $id): JsonResponse
    {
        $this->AppointmentInterface->delete($id);
        return $this->success(202, "Appointment deleted successfully", []);
    }

}
