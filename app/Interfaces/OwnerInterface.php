<?php

namespace App\Interfaces;


interface OwnerInterface
{
    public function index();
    public function all();
    public function show(int|string $id);
    public function delete(int|string $id);
}
