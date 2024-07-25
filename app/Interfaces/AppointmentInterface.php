<?php

namespace App\Interfaces;


interface AppointmentInterface
{
    public function index();
    public function all();
    public function me();
    public function store(array $data);
    public function show(int|string $id);
    public function update(array $data, int|string $id);
    public function delete(int|string $id);
}
