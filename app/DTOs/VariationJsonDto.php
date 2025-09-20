<?php

namespace App\DTOs;

class VariationJsonDto
{
    public function __construct(
        public string $variacao,
        public string $tamanho,
        public string $cor,
        public int $quantidade,
        public string $unidade,
        public int $ordem
    ) {}
}
