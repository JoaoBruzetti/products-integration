<?php

namespace App\Repositories;

use App\Models\Color;

class ColorRepository
{
    public function getAll(): array
    {
        return Color::pluck('id', 'name')->toArray();
    }

    public function create(string $name): Color
    {
        return Color::create(['name' => $name]);
    }
}
