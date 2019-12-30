<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Requests;

use App\Shop\Application\Exceptions\ApiException;
use App\Shop\Infrastructure\Helpers\IdsHelper;

class DeleteProductRequest extends ApiRequest
{

    public string $uuid;

    /**
     * @return bool
     */
    public function validate()
    {
        if (!IdsHelper::isCorrectUuid($this->request->get('id'))) {
            throw ApiException::wrongUuidStructure();
        }

        $this->uuid = $this->request->get('id');

        return true;
    }

}
