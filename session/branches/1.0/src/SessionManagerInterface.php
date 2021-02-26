<?php

declare(strict_types=1);

namespace Pollen\Session;

use Pollen\Support\Proxy\ContainerProxyInterface;

/**
 * @mixin SessionProcessor
 */
interface SessionManagerInterface extends ContainerProxyInterface
{
    /**
     * Récupération de l'instance du gestionnaire de processus de session.
     *
     * @return SessionProcessorInterface
     */
    public function processor(): SessionProcessorInterface;
}