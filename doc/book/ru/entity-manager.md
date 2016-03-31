# EntityManager

## Идеология

Для реализации сервисно-орентированного подхода в модулях zf2, необходимо избегать явного создания сущностей Doctrine2, через
new. Для создания расширяемых сервисов, применяется подход, когда в коде идет работы с интерфейсом, а не с реализацией, данного
интерфейса.

EntityManager - это контейнер используемыей для создания новых экземпляров сущностей.

Пример кода в котором создается сущность Doctrine2:

```php

use \Nnx\Doctrine\EntityManager\EntityManagerInterface

/** @var EntityManagerInterface $entityManager */
$entityManager = $appServiceManager->get(EntityManagerInterface::class);
/** @var TestEntityInterface $entity */
$entity = $entityManager->get(TestEntityInterface::class);

```

В примере выше при получение сущности $entity, заранее неизвестно имя класса сущности, зато известно что она должна
реализовывать интерфейс TestEntityInterface::class.

Логика определения конкретного класса сущности, который будет имплементировать интерфейс TestEntityInterface::class, реализуется
в контейнере \Nnx\Doctrine\EntityManager\EntityManagerInterface.

## Описание плагин менеджера \Nnx\Doctrine\EntityManager\EntityManagerInterface

Характеристика                                                   |Значение
-----------------------------------------------------------------|------------------------------------------------------------------
Имя сервиса                                                      |\Nnx\Doctrine\EntityManager\EntityManagerInterface
Секция в конфигах приложения                                     |nnx_doctrine_object_manager
Имя интерфейса для модуля                                        |\Nnx\Doctrine\EntityManager\EntityManagerProviderInterface
Метод который должен реализовать модуля для возвращаения конфигов|getEntityManagerConfig


Дополнительные методы  \Nnx\Doctrine\EntityManager\EntityManagerInterface

Метод                     |Описание
--------------------------|--------------------------------------------------------------------
getEntityClassByInterface |Получение класса сущности, по интерфейсу
hasEntityClassByInterface |Проверяет можно ли по имени интерфейса получить имя класса сущности

