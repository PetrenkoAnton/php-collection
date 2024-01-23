<?php

declare(strict_types=1);

namespace Collection\Exception\CollectionException;

use Collection\Exception\CollectionException;

use function sprintf;

final class InvalidItemTypeException extends CollectionException
{
    public function __construct(string $collection, string $expected, string $given)
    {
        parent::__construct(
            message: sprintf(
                'Collection: %s | Expected item type: %s | Given: %s',
                $collection,
                $expected,
                $given,
            ),
            code: self::INVALID_ITEM_TYPE,
        );
    }
}
