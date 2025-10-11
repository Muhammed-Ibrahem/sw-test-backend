<?php

declare(strict_types=1);

namespace App\GraphQL\Http;

use Throwable;
use RuntimeException;

use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Error\Error;
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

            $result->setErrorFormatter([self::class, 'formatGraphQLError']);

            $output = $result->toArray(DebugFlag::NONE);
        } catch (Throwable $e) {
            $output = [
                "errors" => [
                    "trace" => $e->getMessage(),
                    "message" => "Internal Server Error",
                    'extensions' => [
                        'code' => 'SERVER_ERROR',
                        'status' => 500,
                        'timestamp' => date(DATE_ATOM)
                    ]
                ]
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }

    public static function formatGraphQLError(Error $error): array
    {
        $prev = $error->getPrevious();

        $code = match ($prev?->getCode()) {
            400 => 'BAD_USER_INPUT',
            401 => 'UNAUTHENTICATED',
            403 => 'FORBIDDEN',
            404 => 'NOT_FOUND',
            409 => 'CONFLICT',
            default => 'INTERNAL_SERVER_ERROR'
        };

        $status = is_int($prev?->getCode()) ? $prev->getCode() : 500;

        return [
            'message' => $prev?->getMessage() ?? $error->getMessage(),
            'path' => $error->getPath(),
            'extensions' => [
                'code' => $code,
                'status' => $status,
                'timestamp' => date(DATE_ATOM),
            ],
        ];
    }
}
