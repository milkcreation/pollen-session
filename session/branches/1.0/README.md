# Pollen Session Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/session/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.4-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

Pollen **Session** Component provides utilities to store and query informations through HTTP Request User's session.

## Installation

```bash
composer require pollen-solutions/session
```

## Basic Usage

```php
use Pollen\Session\SessionManager;

$session = new SessionManager();
try {
    $session->start();
} catch (RuntimeException $e) {
    unset($e);
}

$session->set('key1', 'value1');
$session->set('key2', 'value2');

var_dump($session->all());
```

## Base General API

```php
use Pollen\Session\SessionManager;

$session = new SessionManager();

// Start session (with exception catching for best practice)
try {
    $session->start();
} catch (RuntimeException $e) {
    // throwing error
    throw $e;
    // or mute the error
    // unset($e);
}

// Set data
$session->set('key1', 'value1');
$session->set('key2', 'value2');

// Check existing data
$session->has('key1');

// Get data
$session->get('key1', 'defaultValue');

// Get all data
$session->all();

// Count data
$session->count();

// Delete data
$session->remove('key1');

// Clear all datas
$session->clear();
```

## Base Flash API

A simple way to set flash messages in an HTTP request and to display them after a page redirect.

```php
use Pollen\Session\SessionManager;

$session = new SessionManager();

try {
    $session->start();
} catch (RuntimeException $e) {
    unset($e);
}

// Get FlashBag instance
$session->flash();

// Set flash data
$session->flash()->set('key1', 'value1');
$session->flash()->set('key2', 'value2');

// Alternate set flash data helper
$session->flash([
    'key1' => 'value1',
    'key2' => 'value2'
]);

// Check existing data
$session->flash()->has('key1');

// Read data
$session->flash()->peek('key1');

// Read data alternative
$session->flash()->read('key1', 'defaultValue1');

// Read all data
$session->flash()->peekAll();

// Read all data alternative
$session->flash()->readAll();

// Get data and clear
$session->flash()->get('key1');

// Get data and clear alternative
$session->flash('key1', 'defaultValue');

// Get all data and clear
$session->flash()->all();

// Count data
$session->flash()->count();

// Delete data
$session->flash()->remove('key1');

// Clear all data
$session->flash()->clear();
```

## Advanced usage

### Access to the session through an HTTP Request

```php
use Pollen\Session\SessionManager;
use Pollen\Http\Request;

$session = new SessionManager();
try {
    $session->start();
} catch (RuntimeException $e) {
    unset($e);
}

$session->set('key1', 'value1');
$session->set('key2', 'value2');

/** @var  $request */
$request = Request::createFromGlobals();
$request->setSession($session->processor());

var_dump($request->getSession()->all());
```

### Attribute Key Bag

```php
use Pollen\Session\SessionManager;

$session = new SessionManager();
try {
    $session->start();
} catch (RuntimeException $e) {
    unset($e);
}

// Register an attribute key bag
$keyBag = $session->addAttributeKeyBag('specialKey');

// Set data for key
$keyBag->set('test1', 'value1');
$keyBag->set('test2', 'value2');

// Alternate dot syntax allowed
$keyBag->set('test3.childs', ['child1', 'child2', 'child3']);

// Get data
var_dump($keyBag->all());
var_dump($session->get('specialKey'));
```