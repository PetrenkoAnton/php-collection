<?php

declare(strict_types=1);

namespace Collection;

class EntityCollection implements \ArrayAccess, \Countable, \IteratorAggregate,\JsonSerializable
{
    private array $items;

    public function __construct(private string $entityClass) {}

    public function add(mixed $items): void
    {
        if(\is_array($items))
            foreach ($items as $item)
                $this->addItem($item);
        else
            $this->addItem($items);
    }

    public function first(): mixed
    {
        return \reset($this->items) ?: null;
    }

    public function last(): mixed
    {
        return \end($this->items) ?: null;
    }

    public function offsetExists(mixed $offset): bool
    {
        return \array_key_exists($offset, $this->items);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return \array_key_exists($offset, $this->items) ? $this->items[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!($value instanceof $this->entityClass)) {
            throw new \InvalidArgumentException("Invalid object provided. Expected: " . $this->entityClass);
        }
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        if (\array_key_exists($offset, $this->items))
            unset($this->items[$offset]);
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function getIterator()
    {
        var_dump('Not implemented');
        die;
    }

    public function jsonSerialize()
    {
        var_dump('Not implemented');
        die;
    }

    private function addItem(mixed $item) {
        if (!($item instanceof $this->entityClass))
            throw new \InvalidArgumentException("Invalid object provided. Expected: {$this->entityClass}");

        $this->items[] = $item;
    }
}