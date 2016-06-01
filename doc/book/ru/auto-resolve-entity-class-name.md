# Автоопределение класса сущности по его интерфейсу

В модуль входит несколько реализаций механизма определения имени класса сущности по интерфейсу.

## Абстрактная фабрика \Nnx\Doctrine\EntityManager\OrmEntityAbstractFactory.

При использовании \Nnx\Doctrine\EntityManager\OrmEntityAbstractFactory необходимо чтобы:

- Модули должны придерживаться одинаковой структуры расположения сущностей;
- В описании используемых namespace для Doctrine\ORM\Mapping\Driver\DriverChain должен соблюдаться приоритет.

Расмотрим проект со следующей структурой:

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

В вышеприведенном примере в модулях nnx-service\ext-core-module и nnx-service\customVendor-service сознательно повторяется структура модуля nnx-service\core.

Алгоритм определения имени класса сущности по интерфейсу следующий:

- Разбить интерфейс сущности на префикс и "путь": 
    - Разбиение производится по разделителю. По умолчанию это Entity (\Nnx\Service\Core\Entity\CoreServiceInterface -> ['\Nnx\Service\Core\Entity\', 'MyEntity\CoreServiceInterface'];
    - Разделитель может быть задан через настройки модуля (@see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator).
- Применить к получившемуся пути паттерн (@see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern). MyEntity\CoreServiceInterface -> MyEntity\CoreService;
- Пост обработка "пути" к сущности. Можно через настройки модуля указать:
    - Префикс, прибавляемый к имени сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entityNamePrefix);
    - Постфикс, прибавляемый к имени сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entityNamePostfix).
- По имени интерфейса определить имя ObjectManager'a доктрины -> $objectManagerName;
- Получить список namespace сущностей, используемых в данном ObjectManager'е:
    - Считается, что в качестве ObjectManager'a выступает \Doctrine\ORM\EntityManager;
    - Интеграция приложения с Doctrine2 осуществляется с помощью doctrine/doctrine-orm-module;
    - Получаем имя конфигурации из конфига приложения: 
    ```text 
    $configuration = $serviceLocator->get('Config')['doctrine']['entitymanager'][$objectManagerName]['configuration'];
    ```
    - По имени $configuration получаем имя используемого драйвера: 
    ```text
    $driver = $serviceLocator->get('Config')['doctrine']['configuration'][$configuration]['driver'];
    ```
    - По имени драйвера (предполагается, что это Doctrine\ORM\Mapping\Driver\DriverChain) получаем список $namespaces:
    ```text
    $namespaces =  $serviceLocator->get('Config')['doctrine']['driver'][$driver]['drivers'];
    ```
- Считаем, что список $namespaces определяет приоритет при поиске класса, реализующего интерфейс сущности;
- Пробегаемся по списку $namespaces и определяем класс сущности:
    - Для конкретного namespace определяем его префикс (префикс — это первый элемент массива, полученного в результате разибения namespace по разделителю @see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator);
    - К префиксу подставляется "путь" к сущности, полученный в результате постобработки;
    - В случае если существует класс с именем, полученным в результате конкатенации префикса для текущего namespace и "пути" к классу сущности, прекращаем поиск.
- Проверяем, что найденный класс имплементирует интерфейс, для которого происходил поиск.

## Кэширование карты сущностей

Модуль реализует возможность закешировать карту сущностей для сокращения накладных расходов по автоопределению класса сущности на основе имени интерфейса:

Для этих целей предназначена консольная команда:

```bash
php public/index.php entity-map build --objectManager=doctrine.entitymanager.orm_default
```

Алгоритм построения кэша:

- Для ObjectManager'a c заданным именем получаем список имен классов всех сущностей;
- Для каждого класса определяем список интерфейсов (учитываются только интерфейсы, находящикся в модулях, в которых расположены сущности);
- Для каждого интерфейса пробуем получить имя класса. В случае если это возможно, то добавляем в карту (ключ имя интерфейса, значение имя класса);
- Из настроек модуля определяем кэш для сохранения (@see \Nnx\Doctrine\Options\ModuleOptions::$entityMapDoctrineCache);
- Записываем полученную карту в кэш.

В модуль включена абстрактная фабрика \Nnx\Doctrine\EntityManager\EntityMapAbstractFactory, в которой реализована работа
с кэшом:

- В случае если кэш присутствует для ObjectManager'a (имя ObjectManager берется из настроек модуля, к которому принадлежит интерфейс сущности);
- В данном кэше проверяется, есть ли для искомого интерфейса класс, который его реализует.


Для очистки кэша можно использовать консольную команду:

```bash
php public/index.php entity-map clear  --objectManager=doctrine.entitymanager.orm_default
```

## Автоматическое кеширование карты сущностей

Начиная с версии 0.1.14 добавлена возможность автоматически строить кэш карты сущностей, не запуская ни каких, консольных комманд

За логику работы с автоматическим кэшированием отвечают следующие настройки модуля:

Имя параметра                            |Описание
-----------------------------------------|----------------
flagAutoBuildEntityMapDoctrineCache      |Флаг определяет, нужно ли автоматически собирать кэш карты сущностей
flagDisableUseEntityMapDoctrineCache     |Флаг блокирует использования системы кэширования (удобно устанавливать разработчикам во время отладки)
excludeEntityManagerForAutoBuildEntityMap|Список имен ObjectManager'ов, для которых в автоматическом режиме (flagAutoBuildEntityMapDoctrineCache=true) никогда не строится карта сущностей.

По умолчанию автоматическая сборка кэша для карты сущностей выключена.
