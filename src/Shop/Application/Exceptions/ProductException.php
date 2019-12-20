<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

class ProductException extends \Exception
{
    public static function titleIsNotUnique(string $title, string $uuid_found)
    {
        return new self(sprintf('Product title must be a unique value, given: %s. Found product with uuid: %s', $title, $uuid_found));
    }
}