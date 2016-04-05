# Определение Discriminator Maps на уровне сущностей-потомков

## Быстрый старт

Подключить обработчик событий Doctrine2:

```php
use Nnx\Doctrine\DiscriminatorEntry\DiscriminatorEntryListener;

return [
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    DiscriminatorEntryListener::class,
                ],
            ],
        ],

```


В корневой сущности **обязательно нужно указать DiscriminatorMap, хотя бы с одним значением**. Это связано с реализацией
функционала по обработке DiscriminatorMap в Doctrine2. В качестве значения можно указать значение столбаца дискриминатора,
для класса корневой сущности. 


```php
namespace Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RootEntity
 *
 * @ORM\Entity()
 * @ORM\DiscriminatorMap()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap(value={ "rootEntity" = "RootEntity" })
 */
class RootEntity
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}
```

В классе потомке добавить анотацию Nnx\Doctrine\Annotation\DiscriminatorEntry:


```php
namespace Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\Overload;

use Doctrine\ORM\Mapping as ORM;
use Nnx\Doctrine\Annotation as NNXD;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\RootEntity as BaseEntity;

/**
 * Class RootEntity
 *
 * @ORM\Entity()
 * @NNXD\DiscriminatorEntry(value="overload")
 */
class RootEntity extends BaseEntity
{


}


```

В результате в DiscriminatorMap корневой сущности, будет добавлена запись ключом которой будет значение аннотации 
Nnx\Doctrine\Annotation\DiscriminatorEntry (в примере выше это "overload"), а значением - класс сущности потомка
(в примере выше это Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\Overload\RootEntity)

## Описание работы

Наследование сущностей в Doctrine2 реализуется с помощью специальной колонки(*столбец дискриминатора*), добавляемой 
к таблице на которую отображается корневая сущность. Значение в этой колонке должно однозначно определять конечный класс сущности.

Для явного указания карты соответствий используется аннотация @DiscriminatorMap:

```php

namespace MyProject\Model;

/**
 * @Entity
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"person" = "Person", "employee" = "Employee"})
 */
class Person
{
    // ...
}

```

- @DiscriminatorMap определяет какие значения столбца дискриминатора каким классам соответствуют. Например, значение “person” говорит о том, что запись имеет тип Person, а “employee” соответствует типу Employee.
- Названия классов в карте дискриминатора можно полностью не указывать, если они принадлежат одному пространству имен, что и класс, к которому эта карта будет применена.

В случае если DiscriminatorMap не указывается, в качестве значения столбца дискриминатора берется короткое имя класса.
(Например для \Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\Overload\RootEntity будет rootentity).

Поэтому если мы явно не указываем отношение между значением колонки дискриминатора и конкретным классом, необходимо
следить за тем, что бы в цепочке классов потомков короткие имена классов всегда были различны. 

В случае если сущность потомок, находится в другом по отношению к корневой сущности, модуле, мы сталкиваемся с ситуаций
когда в DiscriminatorMap корневой сущности, нужно явно указать класс из другого модуля. Т.е. возникает жесткая связь между модулями.

Для того что бы решить данную проблему используется специальное расширение позволяющие указывать значение колонки
дискриминатора, в сущности потомке.

Для использования данного расширения необходимо зарегистрировать его:

```php
use Nnx\Doctrine\DiscriminatorEntry\DiscriminatorEntryListener;

return [
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    DiscriminatorEntryListener::class,
                ],
            ],
        ],

```

В дальнейшем для добавления в DiscriminatorMap значения из сущности потомка, необходимо использовать аннотацию Nnx\Doctrine\Annotation\DiscriminatorEntry


```php

<?php
namespace Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\Overload;

use Doctrine\ORM\Mapping as ORM;
use Nnx\Doctrine\Annotation as NNXD;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\RootEntity as BaseEntity;

/**
 * Class RootEntity
 *
 * @ORM\Entity()
 * @NNXD\DiscriminatorEntry(value="overload")
 */
class RootEntity extends BaseEntity
{


}


```