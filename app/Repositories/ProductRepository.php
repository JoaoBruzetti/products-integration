<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{

    public function verifyProduct(string $referencia): bool
    {
        return Product::where('id', $referencia)->exists();
    }


    public function insertAll(array $productsData): void
    {
        Product::insert($productsData);
    }
}
