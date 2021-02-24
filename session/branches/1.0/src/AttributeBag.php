<?php

declare(strict_types=1);

namespace Pollen\Session;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag as BaseAttributeBag;

class AttributeBag extends BaseAttributeBag implements AttributeBagInterface
{
    /**
     * @param string $storageKey
     */
    public function __construct(string $storageKey = '_pollen_attributes')
    {
        parent::__construct($storageKey);
    }
}