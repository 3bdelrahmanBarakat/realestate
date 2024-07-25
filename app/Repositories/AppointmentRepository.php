<?php

namespace App\Repositories;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Interfaces\AppointmentInterface;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\DB;

class AppointmentRepository implements AppointmentInterface
{
    use APIResponse;

    public function index()
    {
        $appointments = Pipeline::send(Appointment::query())
            ->through([])
            ->thenReturn()
            ->paginate(10)
            ->withQueryString();

        $appointments->load(['user', 'employee', 'property', 'property.images']);
        return $appointments;
    }

    public function all()
    {

        $query = Pipeline::send(Appointment::query())
            ->through([])
            ->thenReturn();

            if (isset($data['num'])) {
                $query->limit($data['num']);
            }

            $appointments = $query->get();

        $appointments->load(['user', 'employee', 'property', 'property.images']);
        return $appointments;
    }

    public function me()
    {

        $query = Pipeline::send(Appointment::query())
            ->through([])
            ->thenReturn();

            if (isset($data['num'])) {
                $query->limit($data['num']);
            }

            if(auth()->user()->role == "admin")
            {
                $query->where('employee_id', Auth::id());
            } else
            {
                $query->where('user_id', Auth::id());
            }

            $appointments = $query->get();


        $appointments->load(['user', 'employee', 'property', 'property.images']);
        return $appointments;
    }

    public function show(int|string $id)
    {
        $appointment = $this->find($id);
        $appointment->load(['user', 'employee', 'property', 'property.images']);
        return $appointment;
    }

    public function update(array $data, int|string $id): Appointment
    {
        $appointment = $this->find($id);

        DB::transaction(function () use ($data, $appointment) {
            $appointment->update($data);
        });

        $appointment->load(['user', 'employee', 'property']);
        return $appointment;
    }

    public function store(array $data): Appointment
    {
        $appointment = DB::transaction(function () use ($data) {

            $data['employee_id'] = $data['employee_id'];
            $data['user_id'] = Auth::id();
            $startDateTime = Carbon::parse($data['start_date_time']);
            $data['end_date_time'] = $startDateTime->addHours(24)->format('Y-m-d H:i:s');
            $appointment = Appointment::create($data);

            return $appointment;
        });

        $appointment->load(['user', 'employee', 'property']);
        return $appointment;
    }

    public function delete(int|string $id): void
    {
        $appointment = $this->find($id);

        DB::transaction(function () use ($appointment) {
            $appointment->delete();
        });
    }

    public function find(int|string $id): Appointment
    {
        $appointment = Appointment::where("id", $id)->first();

        if (!$appointment) {
            throw new HttpResponseException($this->error(404, "There is no appointment with the given id:{$id}", []));
        }
        $appointment->load(['user', 'employee', 'property', 'property.images']);
        return $appointment;
    }
}
