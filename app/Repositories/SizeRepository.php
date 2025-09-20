<?php

namespace App\Repositories;

use App\Models\Size;

class SizeRepository
{
    public function getAll(): array
    {
        return Size::pluck('id', 'name')->toArray();
    }

    public function create(string $name): Size
    {
        return Size::create(['name' => $name]);
    }
}
