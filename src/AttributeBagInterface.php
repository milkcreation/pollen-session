<?php

declare(strict_types=1);

namespace Pollen\Session;

use Countable;
use IteratorAggregate;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface as BaseAttributeBagInterface;

interface AttributeBagInterface extends BaseAttributeBagInterface, IteratorAggregate, Countable
{
}