<?php

declare(strict_types=1);

namespace Collection\Exception\CollectionException;

use Collection\Exception\CollectionException;

use function sprintf;

final class InvalidKeyCollectionException extends CollectionException
{
    public function __construct(string $collection, int $key)
    {
        parent::__construct(
            message: sprintf(
                'Collection: %s | Invalid key: %d',
                $collection,
                $key,
            ),
            code: self::INVALID_KEY,
        );
    }
}
