<?php

namespace App\DTOs;

class OrderColorsVestiDto
{
    public function __construct(
        public string $color,
        public int $order,

    ) {}
}
