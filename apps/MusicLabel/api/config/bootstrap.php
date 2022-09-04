<?php

/** @noinspection PhpIncludeInspection */

/**
 * File used in tests basically, to autoload classes and deps.
 *
 * rector: ./rector.php
 * phpunit: ./phpunit.xml
 * behat: ./behat.yml
 * psalm: ./psalm.xml
 */

$root_path = dirname(__DIR__, 4);
require_once $root_path . '/vendor/autoload.php';

// Loads envs defined in backend
$backend_path = dirname(__DIR__);
$env = include $backend_path . '/.env.local.php';
foreach ($env as $key => $value) {
    $_ENV[$key] = $_ENV[$key] ?? (isset($_SERVER[$key]) && str_starts_with($key, 'HTTP_') ? $_SERVER[$key] : $value);
}