<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Collection\Collection;

class UnsupportedObjectConstructorWithoutParentCallCollection extends Collection
{
    public function __construct(private object $randomObject)
    {
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function getString(): object
    {
        return $this->randomObject;
    }
}
