<?php

namespace App\Services;

use App\DTOs\ProductDto;
use Illuminate\Support\Facades\File;
use App\Repositories\ProductRepository;

class ProductImportService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function import(string $filename): string
    {

        $path = base_path($filename);
        if (!File::exists($path)) {
            return "Arquivo {$filename} não encontrado!";
        }
        $json = File::get($path);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return "Arquivo {$filename} inválido!";
        }
        $products = $this->productRepository->getAll();
        $toInsert = [];
        $productdsIds = [];
        foreach ($data as $product) {

            try {
                $dto = new ProductDto(...$product);
            } catch (\Throwable $e) {
                continue;
            }

            if (!in_array($dto->referencia, $products)) {
                $toInsert[] = $dto->toArray();
                $productdsIds[] = $dto->referencia;
            }
        }
        if (!empty($toInsert)) {
            $this->productRepository->insertAll($toInsert);
            return "Produtos inseridos: " . implode(", ", $productdsIds);
        }
        return "Nehum produto novo para inserir.";
    }
}
