<?php

namespace App\Repositories;

use App\Models\Unit;

class UnitRepository
{
    public function findByName(string $name): ?Unit
    {
        return Unit::where('name', $name)->first();
    }
    public function create(string $name): Unit
    {
        return Unit::create(['name' => $name]);
    }
}
