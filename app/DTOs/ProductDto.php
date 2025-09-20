<?php

namespace App\DTOs;

class ProductDto
{
    public function __construct(
        public string $referencia,
        public string $nome,
        public float $preco,
        public ?string $descricao = null,
        public ?string $composicao = null,
        public ?string $marca = null,
        public ?float $promocao = null,
        public ?int $peso = null,
        public ?int $altura = null,
        public ?int $largura = null,
        public ?int $tamanho = null,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->referencia,
            'name' => $this->nome,
            'price' => $this->preco,
            'description' => $this->descricao,
            'composition' => $this->composicao,
            'brand' => $this->marca,
            'price_promotion' => $this->promocao,
            'weight' => $this->peso,
            'height' => $this->altura,
            'width' => $this->largura,
            'length' => $this->tamanho,
        ];
    }
}
