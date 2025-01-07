<?php

namespace AmsApp\Utils;

class BaseUtils
{

    /**
     * @return bool
     */
    public static function isNull($Object): bool
    {
        return $Object === null;
    }

    public static function isNotNull($Object): bool
    {
        return $Object !== null;
    }

}