<?php

declare(strict_types=1);

namespace App\GraphQL;

use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

use App\Core\Container\Container;
use App\GraphQL\Factory\MutationTypeFactory;
use App\GraphQL\Factory\QueryTypeFactory;

final class GraphQLSchema
{
    public static function build(Container $container): Schema
    {
        $queryType = QueryTypeFactory::create($container);
        $mutationType = MutationTypeFactory::create($container);

        $config = new SchemaConfig();
        $config->setQuery($queryType);
        $config->setMutation($mutationType);

        return new Schema($config);
    }
}
