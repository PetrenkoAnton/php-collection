<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Collection\Collection;
use Tests\Fixtures\Entities\SecondEntity;

class SecondEntityCollection extends Collection
{
    public function __construct(SecondEntity ...$items)
    {
        parent::__construct(...$items);
    }
}
