<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Http\ApiResponseRepresentations;

use App\Shop\Application\Query\ProductView;

class ProductApiRepresentation implements ProductRepresentation
{

    /**
     * @var ProductView
     */
    private ProductView $productView;

    public function __construct(ProductView $productView)
    {
        $this->productView = $productView;
    }

    public function representation(): array
    {
        return [
            'uuid' => $this->productView->getUuid(),
            'title' => $this->productView->getTitle(),
            'price' => $this->productView->getPrice(),
        ];
    }
}