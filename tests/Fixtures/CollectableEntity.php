<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Collection\Collectable;

class CollectableEntity implements Collectable
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
