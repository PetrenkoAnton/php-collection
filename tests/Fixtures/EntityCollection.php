<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Collection\Collection;
use Tests\Fixtures\Entities\EntityCollectionInterface;

class EntityCollection extends Collection
{
    public function __construct(EntityCollectionInterface ...$items)
    {
        parent::__construct(... $items);
    }
}