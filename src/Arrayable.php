<?php

declare(strict_types=1);

namespace Collection;

interface Arrayable
{
    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function toArray(): array;
}
