<?php

$root_path = dirname(__DIR__, 5);
require_once $root_path . '/vendor/autoload.php';

$backend_catalog = dirname(__DIR__);
$env = include $backend_catalog . '/.env.local.php';

// @todo replace by array_merge...
foreach ($env as $k => $v) {
    $_ENV[$k] = $_ENV[$k] ?? (isset($_SERVER[$k]) && str_starts_with($k, 'HTTP_') ? $_SERVER[$k] : $v);
}