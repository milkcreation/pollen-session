<?php

declare(strict_types=1);

namespace Pollen\Session;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface as BaseFlashBagInterface;

interface FlashBagInterface extends BaseFlashBagInterface
{
    /**
     * Insère une nouvelle valeur à la fin d'une liste.
     *
     * @param string $type
     * @param mixed $value
     *
     * @return void
     */
    public function push(string $type, $value): void;

    /**
     * Retrouve une valeur sans la supprimer.
     *
     * @param string $type
     * @param mixed $default
     *
     * @return string|array|object|null
     */
    public function read(string $type, $default = null);

    /**
     * Retrouve toutes les valeurs sans les supprimer.
     *
     * @return array
     */
    public function readAll(): array;

    /**
     * Supprime une valeur
     *
     * @param string $type
     *
     * @return void
     */
    public function remove(string $type): void;

}