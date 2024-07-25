<?php

namespace App\Interfaces;


interface PropertyInterface
{
    public function index();
    public function all(array $data);
    public function store(array $data);
    public function show(int|string $id);
    public function update(array $data, int|string $id);
    public function hideProperty(array $data,int|string $id);
    public function hiddenProperties();
    public function delete(int|string $id);
}
