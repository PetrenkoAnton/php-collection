<?php

declare(strict_types=1);

namespace Tests\Fixtures\Entities;

use Collection\Arrayable;

class FirstEntity implements EntityInterface, Arrayable
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return ['id' => $this->id];
    }
}
