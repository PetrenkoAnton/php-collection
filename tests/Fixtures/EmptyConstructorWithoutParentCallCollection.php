<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Collection\Collection;

class EmptyConstructorWithoutParentCallCollection extends Collection
{
    public function __construct()
    {
    }
}
