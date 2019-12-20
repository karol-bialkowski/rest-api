<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Requests;

use Symfony\Component\HttpFoundation\Request;

class CreateProductRequest extends ApiRequest {

    public bool $status = false;
    public string $title;
    public int $price;
    public string $errorMessage;

    public function validate()
    {


        //TODO: assert, validations and thorw exception
        $this->status = true;
        $this->title = $this->content['title'];
        $this->price = (int)$this->content['price'];
        $this->errorMessage = 'Title should be string and length must be between 1 and 100 chars.';
    }

}
