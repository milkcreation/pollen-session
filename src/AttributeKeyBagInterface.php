<?php

declare(strict_types=1);

namespace Pollen\Session;

interface AttributeKeyBagInterface
{
    public function all(): array;

    public function clear(): array;

    public function count(): int;

    public function forget(array $names): void;

    public function get(string $name, $default = null);

    public function getKey(): string;

    public function getIterator(): iterable;

    public function has(string $name): bool;

    public function initialize(array &$array): void;

    public function pull(string $name, $default = null);

    public function remove(string $name): void;

    public function replace(array $attributes): void;

    public function set(string $name, $value): void;
}