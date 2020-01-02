<?php

declare(strict_types=1);

namespace App\Shop\Application\Exceptions;

class ProductNotFoundException extends \Exception
{
    /**
     * @param string $uuid
     * @return ProductNotFoundException
     */
    public static function byUuid(string $uuid): ProductNotFoundException
    {
        return new self(sprintf('Not found product with uuid: %s', $uuid));
    }
}