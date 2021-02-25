<?php

declare(strict_types=1);

namespace Pollen\Session;

use ArrayIterator;
use Pollen\Support\Arr;

class AttributeKeyBag implements AttributeKeyBagInterface
{
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var string $key
     */
    private $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function all(): array
    {
        return $this->attributes[$this->key] ?? [];
    }

    public function clear(): array
    {
        $return = $this->attributes[$this->key] ?? [];
        unset($this->attributes[$this->key]);

        return $return;
    }

    public function count(): int
    {
        return count($this->attributes[$this->key] ?? []);
    }

    public function forget(array $names): void
    {
        foreach($names as $name) {
            $this->remove($name);
        }
    }

    public function get(string $name, $default = null)
    {
        return Arr::get($this->attributes, "{$this->key}.{$name}", $default);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getIterator(): iterable
    {
        return new ArrayIterator($this->attributes[$this->key] ?? []);
    }

    public function has(string $name): bool
    {
        return Arr::has($this->attributes, "{$this->key}.{$name}");
    }

    public function initialize(array &$array): void
    {
        $this->attributes = &$array;
    }

    public function pull(string $name, $default = null)
    {
       return Arr::pull($this->attributes, "{$this->key}.{$name}", $default);
    }

    public function remove(string $name): void
    {
        Arr::forget($this->attributes, "{$this->key}.{$name}");
    }

    public function replace(array $attributes): void
    {
        unset($this->attributes[$this->key]);
        foreach ($attributes as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function set(string $name, $value): void
    {
        Arr::set($this->attributes, "{$this->key}.{$name}", $value);
    }
}