<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Http\ApiResponseRepresentations;

use Symfony\Component\HttpFoundation\Response;

class BasicResponse implements BaseResponse
{

    /**
     * @var int
     */
    private int $http_code;
    /**
     * @var string
     */
    private string $message;
    private $payload;

    public function __construct(int $http_code, $payload = null, string $message = null)
    {
        $this->http_code = $http_code;
        $this->message = $message;
        $this->payload = $payload;
    }

    public function response(): Response
    {

        $content = [
            'message' => $this->message,
            'payload' => $this->payload
        ];

        return new Response(
            json_encode($content),
            $this->http_code,
            ['Content-Type' => 'application/json']
        );
    }
}