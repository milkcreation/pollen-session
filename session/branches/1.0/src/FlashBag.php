<?php

declare(strict_types=1);

namespace Pollen\Session;

use Pollen\Support\Arr;
use Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag as BaseFlashBag;

class FlashBag extends BaseFlashBag implements FlashBagInterface
{
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param string $storageKey
     */
    public function __construct(string $storageKey = '_pollen_flashes')
    {
        parent::__construct($storageKey);
    }

    /**
     * @inheritDoc
     */
    public function add(string $type, $message): void
    {
        Arr::add($this->attributes, "new.{$type}", $message);
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        $return = $this->attributes['display'];
        $this->attributes['display'] = [];

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function get(string $type, $default = null)
    {
        if (!$this->has($type)) {
            return $default;
        }

        $return = Arr::get($this->attributes, "display.{$type}", $default);

        $this->remove($type);

        return $return;
    }

    /**
     * @inheritDoc
     */
    public function has(string $type): bool
    {
        return Arr::has($this->attributes, "display.{$type}");
    }

    /**
     * @inheritDoc
     */
    public function initialize(array &$flashes): void
    {
        $this->attributes = &$flashes;

        $this->attributes['display'] = array_key_exists('new', $this->attributes) ? $this->attributes['new'] : [];
        $this->attributes['new'] = [];
    }

    /**
     * {@inheritdoc}
     */
    public function peek(string $type, array $default = [])
    {
        return Arr::get($this->attributes, "display.{$type}", $default);
    }

    /**
     * @inheritDoc
     */
    public function read(string $type, $default = null)
    {
        if (!$this->has($type)) {
            return $default;
        }
        $value = $this->peek($type);

        if (count($value) <= 1 && is_scalar($value[0])) {
            return reset($value);
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function readAll(): array
    {
        $flashes = $this->peekAll();
        $values = [];

        foreach ($flashes as $key => $value) {
            $values[$key] = $this->read($key);
        }

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function remove(string $type): void
    {
        Arr::forget($this->attributes, "display.{$type}");
    }

    /**
     * @inheritDoc
     */
    public function set(string $type, $messages): void
    {
        Arr::set($this->attributes, "new.{$type}", $messages);
    }
}