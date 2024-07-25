<?php

namespace App\Interfaces;


interface PropertyListingInterface
{
    public function index();
    public function all(array $data);
    public function me();
    public function store(array $data);
    public function show(int|string $id);
    public function update(array $data, int|string $id);
    public function delete(int|string $id);
}
