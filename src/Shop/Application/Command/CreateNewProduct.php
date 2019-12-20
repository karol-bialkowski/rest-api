<?php

declare(strict_types=1);

namespace App\Shop\Application\Command;

class CreateNewProduct
{
    private string $title;
    private int $price;

    public function __construct(string $title, int $price)
    {
        $this->title = $title;
        $this->price = $price;
    }


    public function title(): string
    {
        return $this->title;
    }

    public function price(): int
    {
        return $this->price;
    }
}