<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

$config = [
    Module::CONFIG_KEY => [

    ]
];

return array_merge_recursive(
    include __DIR__ . '/moduleOptions.config.php',
    include __DIR__ . '/serviceManager.config.php',
    $config
);