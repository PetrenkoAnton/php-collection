<?php

declare(strict_types=1);

namespace Collection;

use Collection\Exception\CollectionException\InvalidConstructorDeclarationException;
use Collection\Exception\CollectionException\InvalidItemTypeException;
use Collection\Exception\CollectionException\InvalidKeyException;
use Collection\Exception\Internal\HelperException;
use Countable;
use ReflectionClass;

use function array_filter;
use function array_map;
use function array_values;
use function count;
use function is_a;
use function reset;

abstract class Collection implements Arrayable, Collectable, Countable
{
    protected array $items = [];

    public function __construct(Collectable ...$items)
    {
        $this->items = $items;
    }

    /**
     * @throws InvalidConstructorDeclarationException
     * @throws InvalidItemTypeException
     */
    public function add(Collectable $item): void
    {
        $this->validate($item);

        $this->items[] = $item;
    }

    public function filter(callable $callback): self
    {
        $copy = clone $this;
        $copy->items = array_values(array_filter($this->items, $callback));

        return $copy;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @throws InvalidKeyException
     */
    public function getItem(int $key): Collectable
    {
        return $this->items[$key] ?? throw new InvalidKeyException($this::class, $key);
    }

    /**
     * @throws InvalidKeyException
     */
    public function first(): Collectable
    {
        return reset($this->items) ?: throw new InvalidKeyException($this::class, 0);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toArray(): array
    {
        return array_map(
            static function (Collectable $item): Collectable | array {
                /** @var Collectable|Arrayable $item */
                $methodExists = (new ReflectionClass($item))->implementsInterface(Arrayable::class);

                /** @psalm-suppress PossiblyUndefinedMethod */
                return $methodExists ? $item->toArray() : $item;
            },
            $this->items,
        );
    }

    /**
     * @throws InvalidConstructorDeclarationException
     * @throws InvalidItemTypeException
     */
    private function validate(Collectable $item): void
    {
        try {
            $expectedClass = Helper::getConstructorFirstParameterClassName($this);
        } catch (HelperException) {
            throw new InvalidConstructorDeclarationException($this::class);
        }

        /** @psalm-suppress ArgumentTypeCoercion */
        if (!is_a($item, $expectedClass)) {
            throw new InvalidItemTypeException($this::class, $expectedClass, $item::class);
        }
    }
}
