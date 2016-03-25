<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test;

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use RuntimeException;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Class Bootstrap
 *
 * @package Nnx\Doctrine\PhpUnit\Test
 */
class Bootstrap
{
    /**
     * Настройка тестов
     *
     * @throws \RuntimeException
     */
    public static function init()
    {
        static::initAutoloader();
    }


    /**
     * Инициализация автозагрузчика
     *
     * @return void
     *
     * @throws RuntimeException
     */
    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');
        if (is_readable($vendorPath . '/autoload.php')) {

            /** @noinspection PhpIncludeInspection */
            include $vendorPath . '/autoload.php';
        }

        if (!class_exists(AutoloaderFactory::class)) {
            $errMsg = sprintf('Error init autoloader. Autoloader class %s not exists', AutoloaderFactory::class);
            throw new RuntimeException($errMsg);
        }

        try {
            AutoloaderFactory::factory([
                StandardAutoloader::class => [
                    'autoregister_zf' => true,
                    'namespaces' => [
                        'Nnx\\Doctrine' => __DIR__ . '/../../src/',
                        __NAMESPACE__ => __DIR__ . '/tests/',
                        'Nnx\\Doctrine\\PhpUnit\\TestData' => __DIR__ . '/_files'
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            $errMsg = 'Error init autoloader';
            throw new RuntimeException($errMsg, $e->getCode(), $e);
        }
    }

    /**
     * @param $path
     *
     * @return bool|string
     */
    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();
