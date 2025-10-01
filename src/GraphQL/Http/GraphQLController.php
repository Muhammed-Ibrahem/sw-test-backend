<?php

declare(strict_types=1);

namespace App\GraphQL\Http;

use Throwable;
use RuntimeException;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Error\DebugFlag;

use App\Core\Container\Container;
use App\GraphQL\GraphQLSchema;

final class GraphQLController
{
    public static function handle(Container $container)
    {
        try {
            $schema = GraphQLSchema::build($container);

            $rawInput = file_get_contents("php://input");

            if ($rawInput === false) {
                throw new RuntimeException("Failed to get php://input");
            }

            $input = json_decode(json: $rawInput, associative: true);
            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;

            $result = GraphQLBase::executeQuery(
                schema: $schema,
                source: $query,
                rootValue: null,
                contextValue: null,
                variableValues: $variableValues
            );

            $output = $result->toArray(DebugFlag::INCLUDE_TRACE);
        } catch (Throwable $e) {
            $output = [
                "error" => [
                    "message" => $e->getMessage(),
                    "trace" => $e->getTraceAsString(),
                ]
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}
