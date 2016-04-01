<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder;

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;

return [
    'nnx_doctrine' => [
        'entityMapDoctrineCache' => 'doctrine.cache.filesystem',
        'flagAutoBuildEntityMapDoctrineCache' => true,
        'excludeEntityManagerForAutoBuildEntityMap' => [
            'doctrine.entitymanager.orm_default'
        ]
    ],
    
    'doctrine' => [
        'cache' => [
            'filesystem' => [
                'directory' => TestPaths::getPathToDoctrineModuleFilesystemCacheDir()
            ]
        ],
        'entitymanager' => [
            'test' => [
                'configuration' => 'test',
                'connection'    => 'test',
            ]
        ],
        'connection' => [
            'test' => [
                'configuration' => 'test',
                'eventmanager'  => 'orm_default',
            ]
        ],
        'configuration' => [
            'test' => [
                'metadata_cache'    => 'array',
                'query_cache'       => 'array',
                'result_cache'      => 'array',
                'hydration_cache'   => 'array',
                'driver'            => 'test',
                'generate_proxies'  => true,

                'proxy_dir'         => TestPaths::getPathToDoctrineProxyDir(),
                'proxy_namespace'   => 'DoctrineORMModule\Proxy',
                'filters'           => [],
                'datetime_functions' => [],
                'string_functions' => [],
                'numeric_functions' => [],
                'second_level_cache' => []
            ]
        ],
        'driver' => [
            'test' => [
                'class'   => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => [
                    'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule3\\Entity' => 'testModule3',
                    'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule1\\Entity' => 'testModule1',
                    'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule2\\Entity' => 'testModule2',
                ]
            ]
        ]
    ]
];