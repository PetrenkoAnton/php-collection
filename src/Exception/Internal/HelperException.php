<?php

declare(strict_types=1);

namespace Collection\Exception\Internal;

use Exception;

final class HelperException extends Exception
{
    public function __construct(private string $itemClassName)
    {
        parent::__construct();
    }

    public function getItemClassName(): string
    {
        return $this->itemClassName;
    }
}
