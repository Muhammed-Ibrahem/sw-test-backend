<?php

declare(strict_types=1);

namespace App;

use PDO;
use FastRoute;

use App\Core\Container\Container;
use App\Core\Database\Database;
use App\Core\Router\Router;

use App\Config\Config;
use App\GraphQL\Http\GraphQLController;

final class App
{
    private Database $db;

    public function __construct(
        protected Container $container,
        protected array $request,
        protected Config $config
    ) {
        $this->db = new Database($config->db ?? []);

        $this->container->set(PDO::class, fn() => $this->db->getConnection());
    }

    public function bootstrapApplication(): self
    {
        $apiHandler = fn() => GraphQLController::handle($this->container);

        $router = new Router($apiHandler);

        $routeInfo = $router->dispatch(
            httpMethod: $this->request['method'],
            uri: $this->request['uri']
        );

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                echo "Error 404: Route Not Found";
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                echo "Error 405: Method Not Allowed";
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                echo $handler($vars);
                break;
        }
        return $this;
    }
}
