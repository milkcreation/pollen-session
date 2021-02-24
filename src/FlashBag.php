<?php

declare(strict_types=1);

namespace Pollen\Session;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBag as BaseFlashBag;

class FlashBag extends BaseFlashBag implements FlashBagInterface
{
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
    public function read(string $key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }
        $value = $this->peek($key);

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
}