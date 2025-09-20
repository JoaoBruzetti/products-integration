<?php

namespace App\Services;

use App\DTOs\VariationJsonDto;
use App\Repositories\VariationRepository;
use App\Repositories\ColorRepository;
use App\Repositories\SizeRepository;
use App\Repositories\UnitRepository;
use App\Repositories\ProductRepository;

class VariationImportService
{
    protected VariationRepository $variationRepository;
    protected ColorRepository $colorRepository;
    protected SizeRepository $sizeRepository;
    protected UnitRepository $unitRepository;
    protected ProductRepository $productRepository;

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
    }

    /**
     * @param VariationJsonDto[] $variationsDto
     * @return array
     */
    public function import(array $variationsDto): array
    {
        $toInsert = [];
        foreach ($variationsDto as $dto) {
            if (!$dto instanceof VariationJsonDto) {
                continue;
            }

            $parts = explode('_', $dto->variacao);
            $productId = $parts[0] ?? null;
            if (!$productId || !$this->productRepository->findById($productId)) {
                continue;
            }

            $color = $this->colorRepository->findByName($dto->cor) ?? $this->colorRepository->create($dto->cor);
            $size = $this->sizeRepository->findByName($dto->tamanho) ?? $this->sizeRepository->create($dto->tamanho);
            $unit = $this->unitRepository->findByName($dto->unidade) ?? $this->unitRepository->create($dto->unidade);

            $toInsert[] = [
                'order' => $dto->ordem,
                'quantity' => $dto->quantidade,
                'product_id' => $productId,
                'color_id' => $color->id,
                'size_id' => $size->id,
                'unit_id' => $unit->id,
            ];
        }
        if (!empty($toInsert)) {
            $this->variationRepository->insertMany($toInsert);
        }
        return $toInsert;
    }
}
