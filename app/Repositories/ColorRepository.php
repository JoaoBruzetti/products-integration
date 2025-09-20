<?php

namespace App\Repositories;

use App\Models\Color;

class ColorRepository
{
    public function findByName(string $name): ?Color
    {
        return Color::where('name', $name)->first();
    }
    public function create(string $name): Color
    {
        return Color::create(['name' => $name]);
    }
}
