<?php

declare(strict_types=1);

namespace Test;

use Collection\Collection;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\FirstEntity;

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

        $this->collection = new Collection(FirstEntity::class, $this->items);
    }

    public function testCountMethod(): void
    {
        $this->assertEquals(\count($this->items), $this->collection->count());
    }
//
//    public function testIterator(): void
//    {
//        $i = 0;
//        foreach ($this->collection as $item) {
//            $i++;
//            $this->assertInstanceOf(DummyEntity::class, $item);
//        }
//        $this->assertEquals(is_countable($this->items) ? \count($this->items) : 0, $i);
//    }
//
//    public function testValidateAdd(): void
//    {
//        $this->expectException(\InvalidArgumentException::class);
//        $this->collection->add(new \stdClass());
//    }
//
//    public function testAddMethod(): void
//    {
//        $count = \count($this->collection);
//        $this->collection->add([new FirstExampleEntity()]);
//        $this->assertEquals((++$count), \count($this->collection));
//    }
//
//    public function testClear(): void
//    {
//        $this->collection->add(new DummyEntity(1));
//        $this->collection->add(new DummyEntity(2));
//        $this->collection->clear();
//        $this->assertEquals(0, $this->collection->count());
//    }
//
//    public function testArrayAccess(): void
//    {
//        $key = 4;
//        $oldCount = $this->collection->count();
//        $item = new DummyEntity(3);
//        $this->collection[$key] = $item;
//        $this->assertEquals($oldCount + 1, $this->collection->count());
//        $this->assertTrue(isset($this->collection[$key]));
//        $this->assertEquals($item, $this->collection[$key]);
//        unset($this->collection[$key]);
//        $this->assertEquals($oldCount, $this->collection->count());
//    }
}
