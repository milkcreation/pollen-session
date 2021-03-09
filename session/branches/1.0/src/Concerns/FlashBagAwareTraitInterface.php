<?php

declare(strict_types=1);

namespace Pollen\Session\Concerns;

use Pollen\Session\FlashBagInterface;

interface FlashBagAwareTraitInterface
{
    /**
     * Définition|Récupération|Instance du gestionnaire de données de session éphémères.
     *
     * @param string|array|null $key
     * @param mixed $default
     *
     * @return string|array|object|FlashBagInterface
     */
    public function flash($key = null, $default = null);

    /**
     * Définition du gestionnaire de données de session éphémères.
     *
     * @param FlashBagInterface $flashBag
     *
     * @return FlashBagAwareTrait
     */
    public function setFlashBag(FlashBagInterface $flashBag): FlashBagAwareTrait;
}