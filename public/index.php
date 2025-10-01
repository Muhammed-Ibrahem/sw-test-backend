<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

use App\App;
use App\Config\Config;
use App\Core\Container\Container;
use App\Core\Logger\Logger;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



$request = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'uri' => $_SERVER['REQUEST_URI']
];

Logger::log("{$request['method']} {$request['uri']}");

$container = new Container();

$config = new Config($_ENV);

(new App(
    $container,
    $request,
    $config
))->bootstrapApplication();
