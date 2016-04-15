# doctrine

Набор решений для работы с Doctrine2 на проектах ZF2

Данный модуль реализует:

- Менеджер для получения ObjectManager'ов
- Менеджер для создания сущностей Doctrine2 - EntityManager
- Расширение для Doctrine2, позволяющее добавлять значения в DiscriminatorMap из сущностей потомков
- Абстрактная фабрика для менеджера гидратор, создающая \DoctrineModule\Stdlib\Hydrator\DoctrineObject

#Сервисы

## Сервис \Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface

Методы:

Метод                          |Описание
-------------------------------|-----------------
getObjectManagerNameByClassName|Получает имя используемого в модуле ObjectManager'a Doctrine, по имени любого класса модуля
hasObjectManagerNameByClassName|Проверяет есть ли возможность по имени класса модуля, получить имя objectManager'a который используется в данном модуле
hasObjectManagerByClassName    |Проверяет есть ли возможность по имени класса модуля, получить objectManager'a который используется в данном модуле
getObjectManagerByClassName    |По имени класса модуля, получает objectManager'a который используется в данном модуле

## Сервис \Nnx\Doctrine\Service\ObjectManagerServiceInterface

Методы:

Метод                          |Описание
-------------------|-----------------
getRepository      |По имени сущности получает репозиторий для работы с ней
saveEntityObject   |Сохраняет сущность в хранилище
createEntityObject |Создает новую сущность




# Plugin Managers

Имя плагин менеджера                                      |Имя секции в конфигурационных файлах приложения
----------------------------------------------------------|-----------------------------------------------------------------
\Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface|nnx_doctrine_object_manager
\Nnx\Doctrine\EntityManager\EntityManagerInterface        |nnx_entity_manager

# Настройка модуля nnx_doctrine

Ключ                                     |Описание
-----------------------------------------|-----------------------------------------------------------
entitySeparator                          |Строка, используемая как разделитель в полном имени класса сущности(или интерфейса)
entityBodyNamePattern                    |Паттерн по которому из имени интерфейса можно получить строку, являющеюся заготовкой для формирования имени сущности
entityNamePrefix                         |Строка которая добавляется перед  заготовкой имени сущности
entityNamePostfix                        |Строка которая добавляется после заготовки имени сущности
entityMapDoctrineCache                   |Имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache, для сохранения карты сущностей
entityMapDoctrineCachePrefix             |Префикс используемый для генерации ключа кеширования карты сущностей doctrine
metadataReaderCache                      |Имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache для кеширования метаданных сущности
flagAutoBuildEntityMapDoctrineCache      |Флаг определяет, нужно ли автоматически собирать кеш карты сущностей
flagDisableUseEntityMapDoctrineCache     |Флаг блокирует использования системы кеширования (удобно устанавливать разработчикам, во время отладки)
excludeEntityManagerForAutoBuildEntityMap|Список имен ObjectManager'ов, для которых в автоматическом режими (flagAutoBuildEntityMapDoctrineCache=true), никогда не строится карта сущностей
managerRegistry                          |Настройки необходимые для создания экземпляра \Nnx\Doctrine\ManagerRegistry\ManagerRegistry

