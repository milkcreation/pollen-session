<?php

declare(strict_types=1);

namespace Pollen\Session\Concerns;

use InvalidArgumentException;
use Pollen\Session\FlashBagInterface;
use RuntimeException;

/**
 * @see \Pollen\Session\Concerns\FlashBagAwareTraitInterface
 */
trait FlashBagAwareTrait
{
    /**
     * Instance du gestionnaire de données de session éphémères.
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * Définition|Récupération|Instance du gestionnaire de données de session éphémères.
     *
     * @param string|array|null $key
     * @param mixed $default
     *
     * @return string|array|object|null|FlashBagInterface
     */
    public function flash($key = null, $default = null)
    {
        if (!$this->flashBag instanceof FlashBagInterface) {
            if (!method_exists($this, 'getFlashBag')) {
                throw new RuntimeException('FlashBag instance unavailable');
            }
            $this->setFlashBag($this->getFlashBag());
        }

        if (is_null($key)) {
            return $this->flashBag;
        }

        if (is_string($key)) {
            if (!$this->flashBag->has($key)) {
                return $default;
            }
            $value = $this->flashBag->get($key);

            if (count($value) <= 1 && is_scalar($value[0])) {
                return reset($value);
            }
            return $value;
        }

        if (is_array($key)) {
            foreach($key as $k => $v) {
                $this->flashBag->set($k, $v);
            }
            return null;
        }

        throw new InvalidArgumentException('FlashBag method arguments invalid');
    }

    /**
     * Définition du gestionnaire de données de session éphémères.
     *
     * @param FlashBagInterface $flashBag
     *
     * @return static
     */
    public function setFlashBag(FlashBagInterface $flashBag): FlashBagAwareTrait
    {
        $this->flashBag = $flashBag;

        return $this;
    }
}