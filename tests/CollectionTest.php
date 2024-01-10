<?php

declare(strict_types=1);

namespace Test;

use Collection\Collection;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Entities\FirstEntity;
use Tests\Fixtures\EntityCollection;

class CollectionTest extends TestCase
{
    protected Collection $collection;
    protected array $items;

    public function setUp(): void
    {
        $this->items = [
            new FirstEntity(1),
            new FirstEntity(2)
        ];

        $this->collection = new EntityCollection();
    }

    /**
     * @group +
     */
    public function testCountMethod(): void
    {
        $this->assertCount(\count($this->items), $this->collection);
    }
}
