<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

$config = [
    Module::CONFIG_KEY => [

    ]
];

return array_merge_recursive(
    include __DIR__ . '/moduleOptions.config.php',
    include __DIR__ . '/doctrineObjectManager.config.php',
    include __DIR__ . '/entityManager.config.php',
    include __DIR__ . '/serviceManager.config.php',
    $config
);