<?php

namespace App\Services;

use App\DTOs\VariationDto;
use App\Repositories\VariationRepository;
use App\Repositories\ColorRepository;
use App\Repositories\SizeRepository;
use App\Repositories\UnitRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\File;

class VariationImportService
{
    protected VariationRepository $variationRepository;
    protected ColorRepository $colorRepository;
    protected SizeRepository $sizeRepository;
    protected UnitRepository $unitRepository;
    protected ProductRepository $productRepository;


    public array $colors = [];
    public array $sizes = [];
    public array $units = [];

    public function __construct(
        VariationRepository $variationRepository,
        ColorRepository $colorRepository,
        SizeRepository $sizeRepository,
        UnitRepository $unitRepository,
        ProductRepository $productRepository
    ) {
        $this->variationRepository = $variationRepository;
        $this->colorRepository = $colorRepository;
        $this->sizeRepository = $sizeRepository;
        $this->unitRepository = $unitRepository;
        $this->productRepository = $productRepository;
        $this->colors = $this->colorRepository->getAll();
        $this->sizes = $this->sizeRepository->getAll();
        $this->units = $this->unitRepository->getAll();
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
        $variationsId = [];
        foreach ($data as $variation) {

            if(count($toInsert) >= 5000) {
                $this->variationRepository->insertAll($toInsert);
                $toInsert = [];
            }

            try {
                $dto = new VariationDto(...$variation);
            } catch (\Throwable $e) {
                continue;
            }

            $productId = explode('_', $dto->variacao)[0] ?? null;
            if (!$productId || !in_array($productId, $products)) {
                continue;
            }
            $toInsert[] = [
                'order' => $dto->ordem,
                'quantity' => $dto->quantidade,
                'product_id' => (int) $productId,
                'color_id' => $this->verifyAtribute($this->colors, $dto->cor, $this->colorRepository),
                'size_id' => $this->verifyAtribute($this->sizes, $dto->tamanho, $this->sizeRepository),
                'unit_id' => $this->verifyAtribute($this->units, $dto->unidade, $this->unitRepository),
            ];
            $variationsId[] = $dto->variacao;
        }

        if (!empty($toInsert)) {
            $this->variationRepository->insertAll($toInsert);
            return "Variações inseridas: " . implode(", ", $variationsId);
        }

        return "Nehuma variação nova para inserir.";
    }

    private function verifyAtribute(array &$attributes, string $name, $repository): int
    {
        if (isset($attributes[$name])) {
            return $attributes[$name];
        }
        $attribute = $repository->create($name);
        $attributes = $repository->getAll();
        $attributes[$name] = $attribute->id;
        return $attribute->id;
    }
}
