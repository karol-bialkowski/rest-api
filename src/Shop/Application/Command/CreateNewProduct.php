<?php

declare(strict_types=1);

namespace App\Shop\Application\Command;

use App\Shop\Application\Exceptions\ProductException;
use App\Shop\Domain\Product\Entity\Product;

class CreateNewProduct
{
    private string $title;
    private int $price;

    /**
     * CreateNewProduct constructor.
     * @param string $title
     * @param int $price
     * @throws ProductException
     */
    public function __construct(string $title, int $price)
    {

        $strlenTitle = strlen($title);
        if ($strlenTitle < Product::MIN_LENGTH_TITLE || $strlenTitle > Product::MAX_LENGTH_TITLE) {
            throw ProductException::wrongProductTitle($title);
        }

        if ($price === 0 || $price === null || $price > Product::MAX_PRICE) {
            throw ProductException::wrongPriceRange($price);
        }

        $this->title = $title;
        $this->price = $price;
    }


    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function price(): int
    {
        return $this->price;
    }
}