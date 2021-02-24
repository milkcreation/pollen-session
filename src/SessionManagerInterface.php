<?php

declare(strict_types=1);

namespace Pollen\Session;

use Exception;

/**
 * @mixin SessionProcessor
 */
interface SessionManagerInterface
{
    /**
     * Délégation d'appel des méthodes du système de session.
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function __call(string $method, array $arguments);

    /**
     * Récupération de l'instance du gestionnaire de processus de session.
     *
     * @return SessionProcessorInterface
     */
    public function processor(): SessionProcessorInterface;
}