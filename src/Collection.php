<?php

declare(strict_types=1);

namespace Collection;

abstract class Collection implements CollectionInterface, \Countable
{
    protected array $items = [];

    public function filter(callable $callback): Collection
    {
        $copy = clone $this;
        $copy->items = \array_filter($this->items, $callback);

        return $copy;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getItem(int $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    public function first(): mixed
    {
        $first = \reset($this->items);

        return false == $first ? null : $first;
    }

    public function count(): int
    {
        return \count($this->items);
    }
}