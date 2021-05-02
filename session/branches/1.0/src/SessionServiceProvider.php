<?php

declare(strict_types=1);

namespace Pollen\Session;

use Pollen\Container\BaseServiceProvider;
use Pollen\Support\Env;

class SessionServiceProvider extends BaseServiceProvider
{
    /**
     * @var string[]
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
            $sessionManager = new SessionManager([], $this->getContainer());

            if ($tokenID = Env::get('APP_KEY')) {
                $sessionManager->setTokenID($tokenID);
            }

            return $sessionManager;
        });
    }
}
