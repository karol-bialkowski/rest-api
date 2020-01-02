<?php

namespace App\Shop\Domain\Product\Entity;

use Symfony\Component\Validator\Constraints\Uuid;

class Product
{

    protected $id;
    protected string $title;
    protected int $price;
    protected string $uuid;

    //TODO: this is duplicated at Resources/doctrine/mapping/Product.Entity.Product.orm.yml
    public const MIN_LENGTH_TITLE = 2;
    public const MAX_LENGTH_TITLE = 100;
    public const MAX_PRICE = 2147483647; //integer

    public function __construct(string $title, int $price)
    {
        $this->title = $title;
        $this->price = $price;
        $this->uuid = \Ramsey\Uuid\Uuid::uuid4();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

}