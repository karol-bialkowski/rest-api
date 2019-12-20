<?php

declare(strict_types=1);

namespace App\Shop\Application\Command;

class IsUniqueProductName
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }


    public function title(): string
    {
        return $this->title;
    }
    
}