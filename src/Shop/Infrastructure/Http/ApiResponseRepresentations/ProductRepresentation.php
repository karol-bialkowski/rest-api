<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Http\ApiResponseRepresentations;

use App\Shop\Application\Query\ProductView;

interface ProductRepresentation
{
    public function __construct(ProductView $productView);

    public function representation(): array;
}