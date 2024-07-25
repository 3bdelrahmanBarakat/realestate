<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface FavoriteInterface
{
    public function all();
    public function index(Request $request);
    public function toggle(int|string $id);
    public function popularProperties();
    public function delete(int|string $id);
}
