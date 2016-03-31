# Авто определение класса сущности по его интерфейсу

В модуль входит несколько реализаций механизма определения имени класса сущности, по интерфейсу.

## Абстрактная фабрика \Nnx\Doctrine\EntityManager\OrmEntityAbstractFactory.

Расмотрим проект с следующей структурой:

```text
project
    vendor
        nnx-service
            core
                src
                    Entity
                        MyEntity
                            CoreServiceInterface
                            CoreService
            ext-core-module
                src
                    Entity
                        MyEntity
                            CoreService
        customVendor-service
            core
                src
                    Entity
                        MyEntity
                            CoreService
```

В вышеприведенном примере, в модулях nnx-service\ext-core-module, nnx-service\customVendor-service, 
сознательно повторяется структура модуля nnx-service\core.

Алогритм определения имени класса сущности по интерфейсу следующий:

- Разбить интерфейс сущности на префикс и "путь". 
-- Разбиение производится по разделителю - по умолчанию это Entity (\Nnx\Service\Core\Entity\CoreServiceInterface -> ['\Nnx\Service\Core\Entity\', 'MyEntity\CoreServiceInterface']
-- Разделить может быть задан через настройки модуля (@see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator)
- Применить к получившемуся пути паттерн (@see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern). MyEntity\CoreServiceInterface -> MyEntity\CoreService
- Пост обработка "пути" к сущности. Можно через настройки модуля указать:
-- Префикс прибавляемый к имени сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entityNamePrefix)
-- Постфикс прибавляемый к имени сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entityNamePostfix)
- По имени интерфейся определить имя ObjectManager'a доктрины -> $objectManagerName
- Получить список namespace сущностей используемых в данном ObjectManager'е
-- Считается что в качестве ObjectManager'a выступает \Doctrine\ORM\EntityManager
-- Интеграция приложения с Doctrine2 осуществляется с помощью doctrine/doctrine-orm-module
-- Получаем имя конфигурации из конфига приложения $configuration = $serviceLocator->get('Config')['doctrine']['entitymanager'][$objectManagerName]['configuration'];
-- По имени $configuration получаем имя используемого драйвера $driver = $serviceLocator->get('Config')['doctrine']['configuration'][$configuration]['driver'];
-- По имени драйвера(предполагается что это Doctrine\ORM\Mapping\Driver\DriverChain) получаем список $namespaces =  $serviceLocator->get('Config')['doctrine']['driver'][$driver]['drivers'];
- Считаем что список $namespaces, определяет приоритет при поиске класса реализующего интерфейс сущности
- Пробегаемся по списку $namespaces и определяем класс сущности
-- Для конкретного namespace, определяем его префикс (префикс это первый элемент массива полученного в результате разибения namespace по разделителю @see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator)
-- К префиксу подставляется "путь" к сущности полученный в результате пост обработки
-- В случае если существует класс с именем полученным в результате конкатенации префикса для текущего namespace и "пути" к классу сущности, прекращаем поиск
- Проверяем что найденный класс имплементирует интерфейс для которого происходил поиск.

Для **быстрого старта**, при использование \Nnx\Doctrine\EntityManager\OrmEntityAbstractFactory необходимо что бы:

- **Модули должны придерживаться одинаковой структуры расположения сущностей**
- **В описание используемых namespace для Doctrine\ORM\Mapping\Driver\DriverChain, должен соблюдаться приоритет**


## Кеширование карты сущностей

Модуль реализует возможность закешировать карту сущностей, для сокращения накладных расходов по авто определению класса сущности,
на основе имени интерфейса:

Для этих целей предназначена консольная команда:

```bash
php public/index.php entity-map build --objectManager=doctrine.entitymanager.orm_default
```

Алгоритм построения кеша:

- Для ObjectManager'a c заданным именем получаем список имен классов всех сущностей
- Для каждого класса определяем список интерфейсов (учитываются только те интерфейсы которые находятся в модулях в которых расположены сущности)
- Для каждого интерфейса пробуем получить имя класса, в случае если это возможно то добавляем в карту (ключ имя интерфейса, значение имя класса)
- Из настроек модуля определяем кеш для сохранения (@see \Nnx\Doctrine\Options\ModuleOptions::$entityMapDoctrineCache)
- Записываем полученную карту в кеш

В модуль включена абстрактная фабрика \Nnx\Doctrine\EntityManager\EntityMapAbstractFactory, в которой реализована работа
с кешом.

- В случае если кеш присутствует для ObjectManager'a (имя ObjectManager берется из настроек модуля, к которому принадлежит интерфейс сущности)
- В данном кеше проверяется есть ли для искомого интерфейса класс который его реализует


Для очистки кеша можно использовать консольную команду:

```bash
php public/index.php entity-map clear  --objectManager=doctrine.entitymanager.orm_default
```
