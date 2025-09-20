<?php

namespace App\DTOs;

class ProductVestiDto
{
    public function __construct(
        public string $integration_id,
        public string $code,
        public string $name,
        public bool $active,
        public float $price,
        public array $variations,
        public ?string $description = null,
        public ?string $composition = null,
        public ?string $brand = null,
        public ?bool $promotion = null,
        public ?float $price_promotional = null,
        public ?array $categories = [],
        public ?string $weight = null,
        public ?string $height = null,
        public ?string $width = null,
        public ?string $length = null,
        public ?array $order_colors = [],

    ) {}
}
