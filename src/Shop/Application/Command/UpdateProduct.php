<?php

declare(strict_types=1);

namespace App\Shop\Application\Command;

class UpdateProduct
{
    /**
     * @var array
     */
    public array $columns_to_update;
    /**
     * @var string
     */
    public string $uuid;

    /**
     * UpdateProduct constructor.
     * @param string $uuid
     * @param array $columns_to_update
     */
    public function __construct(string $uuid, array $columns_to_update)
    {
        //TODO: refactor to class instead array
        $this->uuid = $uuid;
        $this->columns_to_update = $columns_to_update;
    }


}