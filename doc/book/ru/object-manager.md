# ObjectManager

Модуль предоставляет отдельный менеджер плагинов \Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface,
предназначенный для централизации работы с ObjectManager'ами Doctrine2.

Данный плагин-менеджер предоставляет унифицированный способ получения экземпляров объектов, реализующих \Doctrine\Common\Persistence\ObjectManager.

Характеристика                                                    |Значение
------------------------------------------------------------------|------------------------------------------------------------------
Имя сервиса                                                       |\Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface
Секция в конфигах приложения                                      |nnx_doctrine_object_manager
Имя интерфейса для модуля                                         |\Nnx\Doctrine\ObjectManager\DoctrineObjectManagerProviderInterface
Метод, который должен реализовать модуль для возвращаения конфигов|getDoctrineObjectManagerConfig

## Интеграция с doctrine/doctrine-orm-module

Плагин-менеджер \Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface реализует нативную интеграцию с doctrine/doctrine-orm-module.
Так, например, для получения экземпляра \Doctrine\ORM\EntityManager можно использовать следующий код:

```php

/** @var DoctrineObjectManagerInterface $doctrineObjectManager */
$doctrineObjectManager = $serviceLocator->get(DoctrineObjectManagerInterface::class);
$objectManager = $doctrineObjectManager->get('doctrine.entitymanager.orm_default');

```

## ObjectManager для модулей по умолчанию

Для уменьшения связности модулей удобно исходить из того, что каждый модуль в своих настройках содержит имя ObjectManager'a,
который он использует.

Для стандартизации настройки модулей предназначен интерфейс \Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderInterface.

Если модуль использует nnx/module-options, то появляется унифицированная возможность доступа к настройкам модуля.
Если класс, описывающий настройки модуля, реализует \Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderInterface, то
считается, что данный класс может предоставить имя ObjectManager'a по умолчанию для данного модуля.

Также есть трейт \Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderTrait, реализующий методы, декларированные в 
\Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderInterface.

Пример использования:

```php

use Nnx\ModuleOptions\ModuleOptionsInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderTrait;
use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 */
class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface, ObjectManagerNameProviderInterface
{
    use ObjectManagerNameProviderTrait;
}

```

## Сервис для автоматического получения ObjectManager'a

Если модуль реализует поддержку стандартного механизма получения своих настроек (т.е. подходит под стандарты nnx/module-options), то
есть возможность автоматически по имени любого класса, входящего в этот модуль, получать имя ObjectManager'a или сам ObjectManager'a.

Для этих целей предназначен сервис \Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface.

Базовое описание:

Метод                          |Описание
-------------------------------|-----------------
getObjectManagerNameByClassName|Получает имя используемого в модуле ObjectManager'a Doctrine по имени любого класса модуля
hasObjectManagerNameByClassName|Проверяет, есть ли возможность по имени класса модуля получить имя objectManager'a, который используется в данном модуле
hasObjectManagerByClassName    |Проверяет, есть ли возможность по имени класса модуля получить objectManager'a, который используется в данном модуле
getObjectManagerByClassName    |По имени класса модуля получает objectManager, который используется в данном модуле

Пример использования:

```php

use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Nnx\Doctrine\PhpUnit\TestData\ObjectManagerAutoDetector as App;
use Doctrine\Common\Persistence\ObjectManager;

/** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
$objectManagerAutoDetector = $serviceLocator->get(ObjectManagerAutoDetectorInterface::class);
/** @var ObjectManager $objectManager */
$objectManager = $objectManagerAutoDetector->getObjectManagerByClassName(App\TestModule1\Entity\TestEntity\TestEntityInterface::class);

```
