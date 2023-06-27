<?php

use EsTodosApi\Kernel;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__).'/vendor/autoload.php';

$kernel = new Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);