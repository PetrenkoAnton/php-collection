<?php

declare(strict_types=1);

namespace Collection;

use Collection\Exception\CollectionException;
use Collection\Exception\CollectionException\InvalidItemTypeCollectionException;
use Collection\Exception\CollectionException\InvalidKeyCollectionException;
use Countable;
use ReflectionClass;
use ReflectionException;

/**
 * @psalm-suppress UnusedClass
 */
abstract class Collection implements Countable, Collectable, Arrayable
{
    protected array $items = [];

    public function __construct(Collectable ...$items)
    {
        $this->items = $items;
    }

    /**
     * @throws CollectionException
     */
    public function add(Collectable $item): void
    {
        $this->validate($item);

        $this->items[] = $item;
    }

    public function filter(callable $callback): Collectable
    {
        $copy = clone $this;
        $copy->items = \array_values(\array_filter($this->items, $callback));

        return $copy;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @throws InvalidKeyCollectionException
     */
    public function getItem(int $key): Collectable
    {
        return $this->items[$key] ?? throw new InvalidKeyCollectionException($this::class, $key);
    }

    /**
     * @throws InvalidKeyCollectionException
     */
    public function first(): Collectable
    {
        return \reset($this->items) ?: throw new InvalidKeyCollectionException($this::class, 0);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * @throws ReflectionException
     */
    public function toArray(): array
    {
        return \array_map(
            static function (Collectable $item): Collectable|array {
                /**
                 * @var Collectable|Arrayable $item
                 */
                $methodExists = (new ReflectionClass($item))->implementsInterface(Arrayable::class);
                /**
                 * @psalm-suppress PossiblyUndefinedMethod
                 */
                return $methodExists ? $item->toArray() : $item;
        }, $this->items);
    }

    /**
     * @throws InvalidItemTypeCollectionException
     */
    private function validate(Collectable $item): void
    {
        /**
         * @psalm-suppress UndefinedMethod
         */
        $expectedClass = (new ReflectionClass($this))->getConstructor()?->getParameters()[0]?->getType()->getName();

        if (!\is_a($item, $expectedClass))
            throw new InvalidItemTypeCollectionException($this::class, $expectedClass, $item::class);
    }
}