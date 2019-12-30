<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Requests;

use App\Shop\Application\Exceptions\ApiException;
use App\Shop\Infrastructure\Helpers\IdsHelper;

class DeleteProductRequest extends ApiRequest
{

    public function validate()
    {
        if(!IdsHelper::isCorrectUuid($this->request->get('id'))) {
            throw ApiException::wrongUuidStructure();
        }
        return true;
    }

}
