<?php

namespace App\Repositories;

use App\Models\Unit;

class UnitRepository
{
    public function getAll(): array
    {
        return Unit::pluck('id', 'name')->toArray();
    }

    public function create(string $name): Unit
    {
        return Unit::create(['name' => $name]);
    }
}
