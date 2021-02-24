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
        SessionManagerInterface::class
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(SessionManagerInterface::class, function () {
            return new SessionManager([], $this->getContainer());
        });
    }
}
