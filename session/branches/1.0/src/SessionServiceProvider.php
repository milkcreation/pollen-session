<?php

declare(strict_types=1);

namespace Pollen\Session;

use Pollen\Container\BaseServiceProvider;

class SessionServiceProvider extends BaseServiceProvider
{
    /**
     * @inheritDoc
     */
    protected $provides = [
        SessionInterface::class
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(SessionInterface::class, function () {
            return new Session([], $this->getContainer());
        });
    }
}
