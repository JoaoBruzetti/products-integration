<?php

namespace App\Services;

use App\DTOs\OrderColorsVestiDto;
use App\DTOs\ProductVestiDto;
use App\DTOs\VariationVestiDto;
use App\Repositories\ProductRepository;

class SendVestiService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function send(): string
    {

        $this->productRepository->getAllWithVariations(100, function ($products) {
            $payload = $products->map(function ($product) {
                return new ProductVestiDto(
                    integration_id: $product->id,
                    code: $product->code,
                    name: $product->name,
                    active: $product->active,
                    price: $product->price,

                    variations: $product->variations->map(function ($variation) {
                        return new VariationVestiDto(
                            sku: "{$variation->product_id}_{$variation->size->name}_{$variation->color->name}",
                            size: $variation->size->name,
                            color: $variation->color->name,
                            color_code: $variation->color->code,
                            color_integration_id: "{$variation->product_id}_{$variation->color->name}",
                            quantity: $variation->quantity,
                            order: $variation->order,
                            unit_type: $variation->unit->name,
                        );
                    })->toArray(),

                    description: $product->description,
                    composition: $product->composition,
                    brand: $product->brand,
                    promotion: $product->price_promotional > 0,
                    price_promotional: $product->price_promotional,

                    categories: $product->categories->pluck('name')->toArray(),

                    weight: $product->weight,
                    height: $product->height,
                    width: $product->width,
                    length: $product->length,

                    order_colors: $product->variations->map(function ($variation) {
                        return new OrderColorsVestiDto(
                            color: $variation->color?->name,
                            order: $variation->order,
                        );
                    })->toArray(),
                );
            })->toArray();

            dd($payload);
            //ENVIO PARA VESTI
            // Http::post('https://URL_ENVIOPRODUTO', 'products' => $payload);
        });

        return "Lista de produtos enviada para Vesti com sucesso!";

    }
}
