<?php

declare(strict_types=1);

namespace Pollen\Session;

use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class SessionStorage extends NativeSessionStorage implements SessionStorageInterface
{
}