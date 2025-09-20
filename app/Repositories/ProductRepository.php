<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getAll(): array
    {
        return Product::pluck('id')->toArray();
    }

    public function insertAll(array $productsData): void
    {
        Product::insert($productsData);
    }
}
