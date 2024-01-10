<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Collection\Collection;
use Tests\Fixtures\Entities\EntityInterface;

class EntityCollection extends Collection
{
    public function __construct(EntityInterface ...$items)
    {
        parent::__construct(... $items);
    }
}