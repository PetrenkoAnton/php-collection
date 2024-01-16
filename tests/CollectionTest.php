<?php

declare(strict_types=1);

namespace Test;

use Collection\Collection;
use Collection\Exception\CollectionException;
use Collection\Exception\CollectionException\InvalidItemTypeCollectionException;
use Collection\Exception\CollectionException\InvalidKeyCollectionException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Tests\Fixtures\CollectableEntity;
use Tests\Fixtures\Entities\EntityInterface;
use Tests\Fixtures\Entities\FirstEntity;
use Tests\Fixtures\Entities\FourthEntity;
use Tests\Fixtures\Entities\SecondEntity;
use Tests\Fixtures\Entities\ThirdEntity;
use Tests\Fixtures\EntityInterfaceCollection;
use Tests\Fixtures\SecondEntityCollection;
use Tests\Fixtures\Unsupported\SimpleEntity;
use TypeError;

/**
 * @psalm-suppress UnusedClass
 */
class CollectionTest extends TestCase
{
    private int $firstEntityId;
    private int $secondEntityId;
    private int $fourthEntityId;
    private SecondEntity $secondEntity;
    private FourthEntity $fourthEntity;
    private Collection $collection;

    private function unusedMethod(): array
    {
        return [];
    }

    public function setUp(): void
    {
        [$this->firstEntityId, $this->secondEntityId, $thirdEntityId, $this->fourthEntityId] = [1, 2, 3, 4];

        $this->secondEntity = new SecondEntity($this->secondEntityId);
        $this->fourthEntity = new FourthEntity($this->fourthEntityId);

        $this->collection = new EntityInterfaceCollection(
            new FirstEntity($this->firstEntityId), $this->secondEntity, new ThirdEntity($thirdEntityId),
        );
    }

    /**
     * @group ok
     * @throws CollectionException
     */
    public function testCountMethod(): void
    {
        $this->assertCount(3, $this->collection);
        $this->collection->add($this->fourthEntity);
        $this->assertCount(4, $this->collection);
    }

    /**
     * @group ok
     * @throws CollectionException
     */
    public function testAddMethodArgumentDeclarationIsNotInterface(): void
    {
        $collection = new SecondEntityCollection();
        $collection->add($this->secondEntity);

        $this->assertCount(1, $collection);

        /**
         * @var CollectableEntity $entity
         */
        $entity = $collection->getItem(0);

        $this->assertEquals($this->secondEntityId, $entity->getId());
    }

    /**
     * @group ok
     * @throws CollectionException
     */
    public function testFilterMethod(): void
    {
        $this->collection->add($this->fourthEntity);
        $this->assertCount(4, $this->collection);

        $filtered = $this->collection->filter(fn (EntityInterface $item) => $item->getId() > 3);

        /** @var $filtered Collection */
        $this->assertCount(1, $filtered);

        $this->assertEquals($this->fourthEntityId, $filtered->getItem(0)->getId());
    }

    /**
     * @group ok
     * @throws InvalidKeyCollectionException
     */
    public function testFirstMethod(): void
    {
        $this->assertEquals(FirstEntity::class, \get_class($this->collection->first()));
        $this->assertEquals($this->firstEntityId, $this->collection->first()->getId());
        $this->assertEquals($this->collection->first(), $this->collection->getItem(0));
    }

    /**
     * @group ok
     * @throws InvalidKeyCollectionException
     */
    public function testFirstMethodEmptyCollectionThrowsInvalidKeyCollectionException(): void
    {
        $emptyCollection = new EntityInterfaceCollection();

        $this->expectException(InvalidKeyCollectionException::class);
        $this->expectExceptionMessage('Collection: Tests\Fixtures\EntityInterfaceCollection | Invalid key: 0');
        $this->expectExceptionCode(200);
        $emptyCollection->first();
    }

    /**
     * @group ok
     */
    public function testGetItemsMethod(): void
    {
        $this->assertIsArray($this->collection->getItems());
        $this->assertCount(3, $this->collection->getItems());
    }

    /**
     * @group ok
     */
    public function testGetItemMethod(): void
    {
        $this->assertEquals($this->firstEntityId, $this->collection->getItem(0)->getId());
        $this->assertEquals($this->secondEntity, $this->collection->getItem(1));
        $this->assertEquals($this->secondEntityId, $this->collection->getItem(1)->getId());
    }

    /**
     * @group ok
     * @throws CollectionException
     * @throws InvalidKeyCollectionException
     * @dataProvider dpInvalidKeys
     */
    public function testGetItemMethodInvalidKeyThrowsInvalidKeyCollectionException(int $invalidKey): void
    {
        $this->expectException(InvalidKeyCollectionException::class);
        $this->expectExceptionMessage(
            'Collection: Tests\Fixtures\EntityInterfaceCollection | Invalid key: ' . $invalidKey
        );
        $this->expectExceptionCode(200);

        $this->collection->getItem($invalidKey);
    }

    public function dpInvalidKeys(): array
    {
        return [
            [-100],
            [-1],
            [4],
            [6],
            [100],
        ];
    }

    /**
     * @group ok
     * @throws CollectionException
     */
    public function testAddMethodInvalidItemThrowsInvalidItemTypeCollectionException(): void
    {
        $item = new CollectableEntity(4);

        $this->expectException(InvalidItemTypeCollectionException::class);
        $this->expectExceptionMessage(
            'Collection: Tests\Fixtures\EntityInterfaceCollection | Expected item type: Tests\Fixtures\Entities\EntityInterface | Given: Tests\Fixtures\CollectableEntity'
        );
        $this->expectExceptionCode(100);
        $this->collection->add($item);
    }

    /**
     * @group ok
     * @throws CollectionException
     */
    public function testAddMethodInvalidItemThrowsException(): void
    {
        $item = new SimpleEntity(5);

        $this->expectException(TypeError::class);
        $this->expectExceptionMessageMatches(
            '/^(Collection\\\Collection::add(): Argument #1 \($item\) must be of type Collection\\\Collectable\\, Tests\\\Fixtures\\\Unsupported\\\SimpleEntity given\\, called in \\/)*/'
        );
        $this->collection->add($item);
    }

    /**
     * @group ok
     * @throws ReflectionException
     */
    public function testToArrayMethod(): void
    {
        $this->assertIsArray($this->collection->toArray());
        $this->assertCount(3, $this->collection->toArray());

        // Only FirstEntity implements Arrayable interface
        $this->assertIsArray($this->collection->toArray()[0]);
        $this->assertEquals(['id' => $this->firstEntityId], $this->collection->toArray()[0]);

        $this->assertEquals(SecondEntity::class, $this->collection->toArray()[1]::class);
        $this->assertEquals(ThirdEntity::class, $this->collection->toArray()[2]::class);
    }
}
