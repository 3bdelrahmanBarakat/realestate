<?php

namespace App\Interfaces;


interface ProductAttributeInterface
{
    public function all();
    public function store(array $data);
    public function delete(int|string $id);
}
