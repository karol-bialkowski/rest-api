<?php

declare(strict_types=1);

namespace App\Shop\Infrastructure\Requests;

use Symfony\Component\HttpFoundation\Request;

abstract class ApiRequest {

    /**
     * @var Request
     */
    private Request $request;
    protected $content;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->content =  json_decode($request->getContent(), true);
    }

}
