<?php

declare(strict_types=1);

namespace App\Shop\Application\Query;

interface ProductQuery
{
    public function isUniqueTitle(string $title);
}