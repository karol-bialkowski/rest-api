<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Requests;

use App\Shop\Application\Exceptions\ApiException;
use App\Shop\Application\Exceptions\ProductException;
use App\Shop\Infrastructure\Helpers\IdsHelper;

class UpdateProductRequest extends ApiRequest
{

    public string $uuid;
    public $title;
    public $price;

    /**
     * @return bool
     * @throws ProductException
     */
    public function validate()
    {
        if (!IdsHelper::isCorrectUuid($this->request->get('id'))) {
            throw ApiException::wrongUuidStructure();
        }

        if (!key_exists('title', $this->content) && !key_exists('price', $this->content)) {
            throw ProductException::missingAtLeastProductTitleOrPrice();
        }

        //TODO: validate title and/or price
        $this->uuid = $this->request->get('id');
        $this->title = null;
        $this->price = null;

        if (isset($this->content['title']) && !empty($this->content['title'])) {
            $this->title = $this->content['title'];
        }

        if (isset($this->content['price']) && !empty($this->content['price'])) {
            $this->price = $this->content['price'];
        }

        return true;
    }

}
