<?php

declare(strict_types=1);

namespace Pollen\Session;

use BadMethodCallException;
use Exception;
use Pollen\Support\Concerns\ConfigBagAwareTrait;
use Pollen\Support\Concerns\ContainerAwareTrait;
use Psr\Container\ContainerInterface as Container;
use SessionHandler;
use SessionHandlerInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\StrictSessionHandler;
use RuntimeException;
use Throwable;

/**
 * @mixin SessionProcessor
 */
class SessionManager implements SessionManagerInterface
{
    use ConfigBagAwareTrait;
    use ContainerAwareTrait;

    /**
     * Instance principale.
     * @var static|null
     */
    private static $instance;

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

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * Récupération de l'instance principale.
     *
     * @return static
     */
    public static function getInstance(): SessionManagerInterface
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new RuntimeException(sprintf('Unavailable [%s] instance', __CLASS__));
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