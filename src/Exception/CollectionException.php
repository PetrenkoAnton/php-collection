<?php

declare(strict_types=1);

namespace Collection\Exception;

use Exception;

class CollectionException extends Exception
{
    public const INVALID_ITEM_TYPE = 100;
    public const INVALID_KEY = 200;
    public const INVALID_CONSTRUCTOR_DECLARATION = 300;

    public function __construct(string $message, int $code)
    {
        parent::__construct(
            message: $message,
            code: $code,
        );
    }
}
