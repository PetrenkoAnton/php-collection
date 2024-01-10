<?php

declare(strict_types=1);

namespace Tests\Fixtures\Entities;

use Collection\Collectable;

interface EntityInterface extends Collectable
{
    public function getId(): int;
}