<?php

declare(strict_types=1);

namespace App\Shop\Application\Exceptions;

use App\Shop\Domain\Product\Entity\Product;

class ProductException extends \Exception
{
    /**
     * @param string $title
     * @param string $uuid_found
     * @return ProductException
     */
    public static function titleIsNotUnique(string $title, string $uuid_found)
    {
        return new self(sprintf('Product title must be a unique value, given: %s. Found product with uuid: %s', $title, $uuid_found));
    }

    /**
     * @param string $key
     * @return ProductException
     */
    public static function missingKey(string $key)
    {
        return new self(sprintf('Missing %s', $key));

    }

    public static function wrongProductTitle(string $title)
    {
        return new self(sprintf('Title length must be between ' . Product::MIN_LENGTH_TITLE . ' and ' . Product::MAX_LENGTH_TITLE, $title));
    }

    public static function wrongPriceStructure($price)
    {
        return new self(sprintf('Wrong price value. Only digits is allowed. Given: %s', $price));
    }

    public static function wrongPriceRange($price)
    {
        return new self(sprintf('Wrong price range value. Max value is ' . Product::MAX_PRICE . ', given price: %s', $price));
    }

    public static function missingAtLeastProductTitleOrPrice()
    {
        return new self(sprintf('Title or price is required to update product details.'));
    }
}