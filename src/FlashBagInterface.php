<?php

declare(strict_types=1);

namespace Pollen\Session;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface as BaseFlashBagInterface;

interface FlashBagInterface extends BaseFlashBagInterface
{
    /**
     * Retrouve une valeur sans la supprimer.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return string|array|object|null
     */
    public function read(string $key, $default = null);

    /**
     * Retrouve toutes les valeurs sans les supprimer.
     *
     * @return array
     */
    public function readAll(): array;

}