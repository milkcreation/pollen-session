<?php

declare(strict_types=1);

namespace Pollen\Session;

use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag as BaseMetadataBag;

class MetadataBag extends BaseMetadataBag implements MetadataBagInterface
{
    /**
     * @param string $storageKey
     * @param int $updateThreshold
     */
    public function __construct(string $storageKey = '_pollen_metas', int $updateThreshold = 0)
    {
        parent::__construct($storageKey, $updateThreshold);
    }
}