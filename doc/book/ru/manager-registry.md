# ManagerRegistry

Для унификации работы с доступными ObjectManager'ами, а также с соединениями к базе данных разработчик Doctrine, предлагают
самостоятельно реализовать менеджер хранилищ \Doctrine\Common\Persistence\AbstractManagerRegistry.

Модуль nnx/doctrine, реализует \Nnx\Doctrine\ManagerRegistry\ManagerRegistry (наследуется от \Doctrine\Common\Persistence\AbstractManagerRegistry).

## Получения ManagerRegistry через ServiceLocator приложения

ManagerRegistry доступен в виде службы зарегистрированной в ServiceLocator приложения. Пример получения:

```php

use Nnx\Doctrine\ManagerRegistry\ManagerRegistry;

/** @var ManagerRegistry $managerRegistry */
$managerRegistry = $serviceLocator->get(ManagerRegistry::class);

```

## Получения ManagerRegistry через событие

Для получения ManagerRegistry через событие необходимо:

- добавит в идентификаторы EventManager'a - 'DoctrineManagerRegistry'
- бросить событие 'get.doctrineManagerRegistry'

Пример получения:

```php

$eventManager = new EventManager();
$eventManager->addIdentifiers('DoctrineManagerRegistry');

$result = $eventManager->trigger('get.doctrineManagerRegistry');
/** @var \Nnx\Doctrine\ManagerRegistry\ManagerRegistry $managerRegistry */
$managerRegistry = $result->last();

```


## Список доступных соеденений к базе данных

При создание объекта службы  \Nnx\Doctrine\ManagerRegistry\ManagerRegistry, в фабрике \Nnx\Doctrine\ManagerRegistry\ManagerRegistryFactory,
происходит формирование списка доступных соединений к базе данных.

Список доступных соединений к базе данных формируется на основе:

- Результатов события @see \Nnx\Doctrine\ManagerRegistry\ManagerRegistryFactory::EVENT_BUILD_LIST_CONNECTIONS
- Конфигурационных данных модуля $appConfig['nnx_doctrine']['managerRegistry']['connections'] ($appConfig - имеется в виду конфиг приложения)

В модуль nnx/doctrine входит обработчик события \Nnx\Doctrine\ManagerRegistry\ManagerRegistryFactory::EVENT_BUILD_LIST_CONNECTIONS - \Nnx\Doctrine\ManagerRegistry\ParamsFromDoctrineModuleListener.

Обработчик \Nnx\Doctrine\ManagerRegistry\ParamsFromDoctrineModuleListener получает список доступных соединений к базе данных,
на основе конфига модуля DoctrineORMModule (@see doctrine-orm-module/config/module.config.php)

## Список доступных ObjectManager'ов

При создание объекта службы  \Nnx\Doctrine\ManagerRegistry\ManagerRegistry, в фабрике \Nnx\Doctrine\ManagerRegistry\ManagerRegistryFactory,
происходит формирование списка доступных ObjectManager'ов

Список доступных ObjectManager'ов формируется на основе:

- Результатов события @see \Nnx\Doctrine\ManagerRegistry\ManagerRegistryFactory::EVENT_BUILD_LIST_OBJECT_MANAGERS
- Конфигурационных данных модуля $appConfig['nnx_doctrine']['managerRegistry']['objectManagers'] ($appConfig - имеется в виду конфиг приложения)

В модуль nnx/doctrine входит обработчик события \Nnx\Doctrine\ManagerRegistry\ManagerRegistryFactory::EVENT_BUILD_LIST_OBJECT_MANAGERS - \Nnx\Doctrine\ManagerRegistry\ParamsFromDoctrineModuleListener.

Обработчик \Nnx\Doctrine\ManagerRegistry\ParamsFromDoctrineModuleListener получает список доступных ObjectManager'ов,
на основе конфига модуля DoctrineORMModule (@see doctrine-orm-module/config/module.config.php)


## Получение соеденения к базе данных по его имени

Для получения соеденения к базе данных по его имени, сервис \Nnx\Doctrine\ManagerRegistry\ManagerRegistry бросает событие
\Nnx\Doctrine\ManagerRegistry\ManagerRegistryResourceEvent::RESOLVE_CONNECTION_EVENT.

В состав модуля nnx/doctrine входит обработчик события \Nnx\Doctrine\ManagerRegistry\ManagerRegistryResourceEvent::RESOLVE_CONNECTION_EVENT - \Nnx\Doctrine\ManagerRegistry\ResolverManagerRegistryResourceListener.

Данный обработчик реализует функционал, отвечающий за попытку получить соединение к базе данных, за счет делегирования 
это задачи модулю DoctrineORMModule.

Т.е. в итоге происходит попытка получит из ServiceLocator приложения, сервис с именем вида 'doctrine.connection.CONNECTION_NAME'


## Получение ObjectManager'a по его имени

Для получения ObjectManager'a по его имени, сервис \Nnx\Doctrine\ManagerRegistry\ManagerRegistry бросает событие
\Nnx\Doctrine\ManagerRegistry\ManagerRegistryResourceEvent::RESOLVE_OBJECT_MANAGER_EVENT.

В состав модуля nnx/doctrine входит обработчик события \Nnx\Doctrine\ManagerRegistry\ManagerRegistryResourceEvent::RESOLVE_OBJECT_MANAGER_EVENT - \Nnx\Doctrine\ManagerRegistry\ResolverManagerRegistryResourceListener.

Данный обработчик реализует функционал, отвечающий за попытку получить соединение к базе данных, за счет делегирования 
это задачи службе \Nnx\Doctrine\EntityManager\EntityManagerInterface, зарегистрированной в ServiceLocator приложения

