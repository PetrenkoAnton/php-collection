<?php

declare(strict_types=1);

namespace Collection\Exception\CollectionException;

use Collection\Exception\CollectionException;

use function sprintf;

final class InvalidConstructorDeclarationException extends CollectionException
{
    public function __construct(string $collection)
    {
        parent::__construct(
            message: sprintf('Collection: %s | Err: Invalid constructor declaration', $collection),
            code: self::INVALID_CONSTRUCTOR_DECLARATION,
        );
    }
}
