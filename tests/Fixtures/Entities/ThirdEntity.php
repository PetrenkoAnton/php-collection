<?php

declare(strict_types=1);

namespace Tests\Fixtures\Entities;

class ThirdEntity implements EntityInterface
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
