<?php

declare(strict_types=1);

namespace App\Core\Router;

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

final class Router
{
    protected Dispatcher $dispatcher;

    public function __construct(private $apiHandler)
    {
        // $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
        //     $r->post('/graphql', $this->apiHandler);
        //     $r->get('/_health', fn() => "Server is running");
        // });
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->post('/graphql', $this->apiHandler);
            $r->get('/_health', fn() => "Server is running");
        });
    }

    public function dispatch(string $httpMethod, string $uri): array
    {
        $pos = \strpos($uri, "?");

        if ($pos !== false) {
            $uri = \substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        return $this->dispatcher->dispatch($httpMethod, $uri);
    }
}
