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
     * Récupération du jeton de protection contre les attaques CSRF.
     *
     * @param string|null $tokenID
     *
     * @return string
     */
    public function getToken(?string $tokenID = null): string;

    /**
     * Récupération de l'instance du gestionnaire de processus de session.
     *
     * @return SessionProcessorInterface
     */
    public function processor(): SessionProcessorInterface;

    /**
     * Suppression du jeton de protection contre les attaques CSRF.
     *
     * @param string|null $tokenID
     *
     * @return static
     */
    public function removeToken(?string $tokenID = null): SessionManagerInterface;

    /**
     * Définition de la clé de protection contre les attaques CSRF.
     *
     * @param string|null $tokenID
     *
     * @return static
     */
    public function setTokenID(string $tokenID): SessionManagerInterface;

    /**
     * Contrôle du jeton de protection contre les attaques CSRF.
     *
     * @param string $value
     * @param string|null $tokenID
     *
     * @return bool
     */
    public function verifyToken(string $value, ?string $tokenID = null): bool;
}