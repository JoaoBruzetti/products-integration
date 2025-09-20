<?php

namespace App\Repositories;

use App\Models\Variation;

class VariationRepository
{

    public function insertAll(array $variationsData): void
    {
        Variation::insert($variationsData);
    }

}
