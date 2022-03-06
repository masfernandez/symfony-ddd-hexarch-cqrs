<?php

/**
 * @noinspection PhpUnhandledExceptionInspection
 * @noinspection PhpIncludeInspection
 */

use Masfernandez\MusicLabel\Infrastructure\Api\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

date_default_timezone_set("UTC");

$root_path = dirname(__DIR__, 4);
require_once $root_path . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
Request::setTrustedProxies(
    ['REMOTE_ADDR'],
    Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO
);
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
