<?php

namespace App\Services;

use App\DTOs\ProductJsonDto;

use App\Repositories\ProductRepository;

class ProductImportService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Recebe um array de ProductJsonDto, verifica se já existe pelo campo referencia,
     * e armazena os novos em massa na tabela products.
     *
     * @param ProductJsonDto[] $productsDto
     * @return array Inseridos
     */
    public function import(array $productsDto): array
    {
        $toInsert = [];
        foreach ($productsDto as $dto) {
            if (!$dto instanceof ProductJsonDto) {
                continue;
            }

            if (!$this->productRepository->verifyProduct($dto->referencia)) {
                $toInsert[] = [
                    'id' => $dto->referencia,
                    'name' => $dto->nome,
                    'description' => $dto->descricao,
                    'composition' => $dto->composicao,
                    'brand' => $dto->marca,
                    'price' => $dto->preco,
                    'price_promotion' => $dto->promocao,
                    'weight' => $dto->peso,
                    'height' => $dto->altura,
                    'width' => $dto->largura,
                    'length' => $dto->tamanho
                ];
            }
        }
        if (!empty($toInsert)) {
            $this->productRepository->insertAll($toInsert);
        }
        return $toInsert;
    }
}
