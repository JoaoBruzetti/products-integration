<?php

namespace App\Repositories;

use App\Models\Variation;

class VariationRepository
{
    public function insertMany(array $variationsData): void
    {
        Variation::insert($variationsData);
    }
}
