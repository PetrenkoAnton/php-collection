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

use function get_class;

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

    public function setUp(): void
    {
        [$this->firstEntityId, $this->secondEntityId, $thirdEntityId, $this->fourthEntityId] = [1, 2, 3, 4];

        $this->secondEntity = new SecondEntity($this->secondEntityId);
        $this->fourthEntity = new FourthEntity($this->fourthEntityId);

        $this->collection = new EntityInterfaceCollection(
            new FirstEntity($this->firstEntityId),
            $this->secondEntity,
            new ThirdEntity($thirdEntityId),
        );
    }

    /**
     * @throws CollectionException
     *
     * @group ok
     */
    public function testCountMethod(): void
    {
        $this->assertEquals(3, $this->collection->count());
        $this->collection->add($this->fourthEntity);
        $this->assertCount(4, $this->collection);
    }

    /**
     * @throws CollectionException
     *
     * @group ok
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
     * @throws CollectionException
     *
     * @group ok
     */
    public function testFilterMethod(): void
    {
        $this->collection->add($this->fourthEntity);
        $this->assertCount(4, $this->collection);

        /** @var Collection $filtered */
        $filtered = $this->collection->filter(fn (EntityInterface $item) => $item->getId() > 3);

        $this->assertCount(1, $filtered);

        /** @var EntityInterface $item */
        $item = $filtered->getItem(0);
        $this->assertEquals($this->fourthEntityId, $item->getId());
    }

    /**
     * @throws InvalidKeyCollectionException
     *
     * @group ok
     */
    public function testFirstMethod(): void
    {
        $this->assertEquals(FirstEntity::class, get_class($this->collection->first()));
        /** @var EntityInterface $item */
        $item = $this->collection->first();
        $this->assertEquals($this->firstEntityId, $item->getId());
        $this->assertEquals($this->collection->first(), $this->collection->getItem(0));
    }

    /**
     * @throws InvalidKeyCollectionException
     *
     * @group ok
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
     * @throws InvalidKeyCollectionException
     *
     * @group ok
     */
    public function testGetItemMethod(): void
    {
        /** @var EntityInterface $item */
        $item = $this->collection->getItem(0);
        $this->assertEquals($this->firstEntityId, $item->getId());
        $this->assertEquals($this->secondEntity, $this->collection->getItem(1));

        /** @var EntityInterface $item */
        $item = $this->collection->getItem(1);
        $this->assertEquals($this->secondEntityId, $item->getId());
    }

    /**
     * @throws CollectionException
     * @throws InvalidKeyCollectionException
     *
     * @group ok
     * @dataProvider dpInvalidKeys
     */
    public function testGetItemMethodInvalidKeyThrowsInvalidKeyCollectionException(int $invalidKey): void
    {
        $this->expectException(InvalidKeyCollectionException::class);
        $this->expectExceptionMessage(
            'Collection: Tests\Fixtures\EntityInterfaceCollection | Invalid key: ' . $invalidKey,
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
     * @throws CollectionException
     *
     * @group ok
     */
    public function testAddMethodInvalidItemThrowsInvalidItemTypeCollectionException(): void
    {
        $item = new CollectableEntity(4);

        $this->expectException(InvalidItemTypeCollectionException::class);
        $this->expectExceptionMessage(
            // phpcs:ignore
            'Collection: Tests\Fixtures\EntityInterfaceCollection | Expected item type: Tests\Fixtures\Entities\EntityInterface | Given: Tests\Fixtures\CollectableEntity',
        );
        $this->expectExceptionCode(100);
        $this->collection->add($item);
    }

    /**
     * @throws CollectionException
     *
     * @group ok
     */
    public function testAddMethodInvalidItemThrowsException(): void
    {
        $item = new SimpleEntity(5);

        $this->expectException(TypeError::class);
        $this->expectExceptionMessageMatches(
            // phpcs:ignore
            '/^(Collection\\\Collection::add(): Argument #1 \($item\) must be of type Collection\\\Collectable\\, Tests\\\Fixtures\\\Unsupported\\\SimpleEntity given\\, called in \\/)*/',
        );
        /** @psalm-suppress InvalidArgument */
        $this->collection->add($item);
    }

    /**
     * @throws ReflectionException
     *
     * @group ok
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
