<?php

namespace App\Interfaces;


interface PropertyActionInterface
{
    public function index();
    public function all();
    public function store(array $data);
    public function me();
    public function delete(int|string $id);
}
