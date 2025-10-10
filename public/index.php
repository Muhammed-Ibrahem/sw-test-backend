<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

use App\App;
use App\Config\Config;
use App\Core\Container\Container;
use App\Core\Logger\Logger;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$allowedOrigins = explode(',', $_ENV['ALLOWED_ORIGINS']);
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// If request has an Origin → check it
if ($origin && in_array($origin, $allowedOrigins, true)) {
    header("Access-Control-Allow-Origin: $origin");
}
// If no Origin (Postman, server-side request)
elseif (!$origin && $_ENV["ENVIRONMENT"] === "DEVELOPMENT") {
    header("Access-Control-Allow-Origin: *");
}
// Otherwise → block unknown origins
else {
    http_response_code(403);
    echo json_encode(["error" => "CORS origin not allowed"]);
    exit;
}

header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}




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
