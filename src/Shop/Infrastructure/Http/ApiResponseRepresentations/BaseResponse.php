<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Http\ApiResponseRepresentations;

use Symfony\Component\HttpFoundation\Response;

interface BaseResponse
{
    public function __construct(int $http_code, $payload = null, string $message = null);

    public function response(): Response;
}