<?php

declare(strict_types=1);

namespace Pollen\Session;

use Pollen\Session\Concerns\FlashBagAwareTrait;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

class SessionProcessor extends Session implements SessionProcessorInterface
{
    use FlashBagAwareTrait;

    /**
     * @var array
     */
    private $attributeBagDatas = [];

    /**
     * @var string
     */
    private $attributeStorageKey;

    /**
     * @param SessionStorageInterface|null $storage
     * @param AttributeBagInterface|null $attributes
     * @param FlashBagInterface|null $flashes
     * @param callable|null $usageReporter
     */
    public function __construct(
        SessionStorageInterface $storage = null,
        AttributeBagInterface $attributes = null,
        FlashBagInterface $flashes = null,
        callable $usageReporter = null
    ) {
        $attributes = $attributes ?: new AttributeBag();
        $this->attributeStorageKey = $attributes->getStorageKey();

        parent::__construct($storage, $attributes, $flashes, $usageReporter);
    }

    /**
     * @inheritdoc
     */
    public function registerBag(SessionBagInterface $bag): void
    {
        $this->storage->registerBag(new SessionBagProxy($bag, $this->attributeBagDatas, $this->getUsageIndex(), null));
    }

    /**
     * @inheritDoc
     */
    public function addAttributeKeyBag(string $key, ?AttributeKeyBagInterface $bag = null): AttributeKeyBagInterface
    {
        $bag = $bag ?? new AttributeKeyBag($key);

        if (!$this->has($key) || !is_array($this->get($key))) {
            $this->set($key, []);
        }

        $bag->initialize($this->attributeBagDatas[$this->attributeStorageKey]);

        return $bag;
    }
}