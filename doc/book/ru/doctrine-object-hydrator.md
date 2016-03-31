# Абстрактная фабрика для создания \DoctrineModule\Stdlib\Hydrator\DoctrineObject

## Быстрый старт

- Проверить что в модуле где распологается унаследованный от  \DoctrineModule\Stdlib\Hydrator\DoctrineObject гидратор
    - Добавлен ModuleOptions (при стандартных настройках src\Options\ModuleOptions)
    - Убедиться что ModuleOptions имплементирует \Nnx\ModuleOptions\ModuleOptionsInterface и \Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderInterface
- Убедиться что в настройках модуля задано значение *objectManagerName* , т.е. имя ObjectManager'a используемого в данном модуле

При соблюдение данных условий, гидратор будет создан автоматически с помощью абстрактной фабрики \Nnx\Doctrine\Hydrator\DoctrineObjectHydratorAbstractFactory

Пример:

```php
namespace Nnx\Doctrine\PhpUnit\TestData\DoctrineObjectHydrator\TestModule1\Hydrator;


use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

/**
 * Class TestHydratorChild
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\DoctrineObjectHydrator\TestModule1\Hydrator
 */
class TestHydratorChild extends DoctrineObject
{

}

```

```php

use \Nnx\Doctrine\PhpUnit\TestData\DoctrineObjectHydrator\TestModule1\Hydrator\TestHydratorChild;

/** @var ServiceLocatorInterface $hydratorManager */
$hydratorManager = $appServiceLocator()->get('HydratorManager');
/** @var  \DoctrineModule\Stdlib\Hydrator\DoctrineObject $hydratorManager */
$hydrator = $hydratorManager->get(TestHydratorChild::class);

```


