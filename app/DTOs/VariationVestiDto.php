<?php

namespace App\DTOs;

class VariationVestiDto
{
    public function __construct(
        public string $sku,
        public string $size,
        public string $color,
        public ?string $color_code,
        public string $color_integration_id,
        public int $quantity,
        public int $order,
        public string $unit_type

    ) {}
}
