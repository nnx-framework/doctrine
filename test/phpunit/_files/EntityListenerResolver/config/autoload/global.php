<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver;

use Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Listener\RootEntityListener;
use Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Listener\RootEntityListenerFactory;
use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Module as TestModule1;
use Nnx\Doctrine\Resolver\EntityListenerResolver;
use Nnx\Doctrine\Resolver\EntityListenerResolverFactory;

return [
    'service_manager' => [
        'factories' => [
            RootEntityListener::class     => RootEntityListenerFactory::class,
            EntityListenerResolver::class => EntityListenerResolverFactory::class,
        ],
    ],
    'doctrine'        => [
        'entitymanager' => [
            'test' => [
                'configuration' => 'test',
                'connection'    => 'test',
            ]
        ],
        'connection'    => [
            'test' => [
                'configuration' => 'test',
                'eventmanager'  => 'orm_default',
            ]
        ],
        'configuration' => [
            'test' => [
                'entity_listener_resolver' => EntityListenerResolver::class,
                'metadata_cache'           => 'array',
                'query_cache'              => 'array',
                'result_cache'             => 'array',
                'hydration_cache'          => 'array',
                'driver'                   => 'test',
                'generate_proxies'         => true,

                'proxy_dir'          => TestPaths::getPathToDoctrineProxyDir(),
                'proxy_namespace'    => 'DoctrineORMModule\Proxy',
                'filters'            => [],
                'datetime_functions' => [],
                'string_functions'   => [],
                'numeric_functions'  => [],
                'second_level_cache' => [],
            ]
        ],
        'driver'        => [
            'test' => [
                'class'   => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => [
                    TestModule1::MODULE_NAME . '\\Entity' => 'testModule1',
                ]
            ]
        ]
    ]
];