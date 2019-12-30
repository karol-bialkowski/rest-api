<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;

trait ResponseHelper
{

    /**
     * @param Response $response
     * @return mixed
     */
    public function getDecodedMessage(Response $response)
    {
        return json_decode($response->getContent())->message;
    }

}