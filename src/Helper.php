<?php

declare(strict_types=1);

namespace Collection;

use Collection\Exception\CollectionException\InvalidConstructorDeclarationException;
use ReflectionClass;
use ReflectionNamedType;

class Helper
{
    /**
     * @throws InvalidConstructorDeclarationException
     */
    public static function getConstructorFirstParameterClassName(object $class): string
    {
        /**
         * @var ReflectionNamedType $type
         */
        $type = (new ReflectionClass($class))->getConstructor()?->getParameters()[0]?->getType()
            ?? throw new InvalidConstructorDeclarationException($class::class);

        return $type->getName();
    }
}
