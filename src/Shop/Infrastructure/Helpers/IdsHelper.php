<?php

namespace App\Shop\Infrastructure\Helpers;

class IdsHelper
{

    /**
     * @param string $input
     * @return bool
     */
    public static function isCorrectUuid(string $input)
    {
        preg_match(
            "/([0-9a-fA-F]){8}-([0-9a-fA-F]){4}-([0-9a-fA-F]){4}-([0-9a-fA-F]){4}-([0-9a-fA-F]){12}/",
            $input,
            $matches
        );

        return !empty($matches);
    }

}