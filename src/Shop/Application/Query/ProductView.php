<?php

declare(strict_types=1);

namespace App\Shop\Application\Query;


class ProductView implements ProductQuery {

    public function isUniqueTitle(string $title)
    {
        return true;
    }
}
