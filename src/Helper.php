<?php

declare(strict_types=1);

namespace Collection;

use Collection\Exception\Internal\HelperException;
use ReflectionClass;
use ReflectionNamedType;

class Helper
{
    /**
     * @throws HelperException
     */
    public static function getConstructorFirstParameterClassName(object $class): string
    {
        /**
         * @psalm-suppress PossiblyUndefinedIntArrayOffset
         */
        $type = @(new ReflectionClass($class))->getConstructor()?->getParameters()[0]?->getType();

        /** @psalm-suppress UndefinedMethod */
        if (!$type || $type->isBuiltin()) {
            throw new HelperException($class::class);
        }

        /** @var ReflectionNamedType $type */
        return $type->getName();
    }
}
