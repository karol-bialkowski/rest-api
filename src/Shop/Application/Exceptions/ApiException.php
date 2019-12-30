<?php

declare(strict_types=1);

namespace App\Shop\Application\Exceptions;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ApiException extends BadRequestHttpException
{

    /**
     * @return ApiException
     */
    public static function missingContentRequest()
    {
        return new self(sprintf('Missing content request or empty data.'));
    }

    /**
     * @return ApiException
     */
    public static function wrongUuidStructure()
    {
        return new self(sprintf('Wrong uuid structure.'));
    }

}