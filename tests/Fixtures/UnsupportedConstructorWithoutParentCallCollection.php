<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Collection\Collection;

class UnsupportedConstructorWithoutParentCallCollection extends Collection
{
    public function __construct(private string $randomString)
    {
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function getString(): string
    {
        return $this->randomString;
    }
}
