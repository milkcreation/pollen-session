<?php

declare(strict_types=1);

namespace Pollen\Session;

use BadMethodCallException;
use Exception;
use Pollen\Support\Concerns\ConfigBagTrait;
use Pollen\Support\Concerns\ContainerAwareTrait;
use Psr\Container\ContainerInterface as Container;
use SessionHandler;
use SessionHandlerInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\StrictSessionHandler;
use Throwable;

/**
 * @mixin SessionProcessor
 */
class SessionManager implements SessionManagerInterface
{
    use ConfigBagTrait;
    use ContainerAwareTrait;

    /**
     * Instance du gestionnaire de processus session.
     * @var SessionProcessorInterface
     */
    private $sessionProcessor;

    /**
     * @param array $config
     * @param Container|null $container
     */
    public function __construct(array $config = [], ?Container $container = null)
    {
        $this->setConfig($config);

        if (!is_null($container)) {
            $this->setContainer($container);
        }
    }

    /**
     * @inheritDoc
     */
    public function __call(string $method, array $arguments)
    {
        try {
            return $this->processor()->{$method}(...$arguments);
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new BadMethodCallException(
                sprintf(
                    'Session method call [%s] throws an exception: %s',
                    $method,
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Création d'une instance basée sur le système natif de session.
     *
     * @return SessionProcessorInterface
     */
    protected function createNativeProcessor(): SessionProcessorInterface
    {
        $sessionStorage = new SessionStorage([], $this->createNativeHandler(), new MetadataBag());

        return $this->sessionProcessor = new SessionProcessor($sessionStorage, new AttributeBag(), new FlashBag());
    }

    /**
     * Création d'une instance de traitement basée sur le système de natif de session.
     *
     * @return SessionHandlerInterface
     */
    protected function createNativeHandler(): SessionHandlerInterface
    {
        return new StrictSessionHandler(new SessionHandler());
    }

    /**
     * @inheritDoc
     */
    public function processor(): SessionProcessorInterface
    {
        if ($this->sessionProcessor === null) {
            $this->sessionProcessor = $this->createNativeProcessor();
        }
        return $this->sessionProcessor;
    }
}