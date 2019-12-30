<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Requests;

use App\Shop\Application\Exceptions\ApiException;
use App\Shop\Application\Exceptions\ProductException;
use App\Shop\Domain\Product\Entity\Product;

class CreateProductRequest extends ApiRequest
{

    public bool $status = false;
    public string $title;
    public int $price;
    public string $errorMessage;
    public const REQUIRED_PRODUCT_KEYS = [
        'title', 'price'
    ];

    /**
     * @throws ProductException
     */
    public function validate()
    {

        if(!is_array($this->content) || empty($this->content)) {
            throw ApiException::missingContentRequest();
        }

        foreach (self::REQUIRED_PRODUCT_KEYS as $key) {
            if (!key_exists($key, $this->content)) {
                throw ProductException::missingKey($key);
            }
        }

        $strlenTitle = strlen($this->content['title']);
        if ($strlenTitle < Product::MIN_LENGTH_TITLE || $strlenTitle > Product::MAX_LENGTH_TITLE) {
            throw ProductException::wrongProductTitle($this->content['title']);
        }

        if (!ctype_digit($this->content['price'])) {
            throw ProductException::wrongPriceStructure($this->content['price']);
        }

        if($this->content['price'] === 0 || $this->content['price'] === null || $this->content['price'] > Product::MAX_PRICE) {
            throw ProductException::wrongPriceRange($this->content['price']);
        }

        $this->title = $this->content['title'];
        $this->price = (int)$this->content['price'];
    }

}
