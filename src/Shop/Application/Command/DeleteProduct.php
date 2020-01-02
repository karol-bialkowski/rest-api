<?php

declare(strict_types=1);

namespace App\Shop\Application\Command;

class DeleteProduct
{
    public string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }
}