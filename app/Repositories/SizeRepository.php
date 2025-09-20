<?php

namespace App\Repositories;

use App\Models\Size;

class SizeRepository
{
    public function findByName(string $name): ?Size
    {
        return Size::where('name', $name)->first();
    }
    public function create(string $name): Size
    {
        return Size::create(['name' => $name]);
    }
}
