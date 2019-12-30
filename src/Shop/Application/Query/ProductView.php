<?php

declare(strict_types=1);

namespace App\Shop\Application\Query;


class ProductView implements ProductQuery
{

    /**
     * @var string
     */
    private string $uuid;
    /**
     * @var string
     */
    private string $title;
    /**
     * @var string
     */
    private string $price;

    public function __construct(string $uuid, string $title, string $price)
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->price = $price;
    }

    public function isUniqueTitle(string $title)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getByTitle(string $title)
    {
        // TODO: Implement getByTitle() method.
        // TODO verify all methods, Interface Segragtion principe!
    }
}
