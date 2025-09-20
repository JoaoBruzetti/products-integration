<?php

namespace App\DTOs;

class ProductJsonDto
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
}
