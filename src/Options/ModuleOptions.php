<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Options;

use Zend\Stdlib\AbstractOptions;
use Nnx\ModuleOptions\ModuleOptionsInterface;
use Nnx\Doctrine\Options\ModuleOptionsInterface as CurrentModuleOptionsInterface;

/**
 * Class ModuleOptions
 *
 * @package Nnx\Doctrine\Options
 */
class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface, CurrentModuleOptionsInterface
{
    /**
     * Строка, используемая как разделитель в полном имени класса сущности(или интерфейса), которая разделяет неймспейс
     * на две части: 1) Нейсмпейс в котором расположенные все сущности 2) Постфикс указывающий на кокнетную сущность.
     * Например \Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\TestEntity\TestEntityInterface
     * 1) Разделителем будет \Entity\
     * 2) Неймспейс в котром расположены все сущности будет \Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\
     * 3) Постфикс указывающий на кокнетную сущность будет TestEntity\TestEntityInterface
     *
     * @var string
     */
    protected $entitySeparator;

    /**
     * Паттерн по которому из имени интерфейса можно получить строку, являющеюся заготовкой для формирования имени сущности
     *
     * @var string
     */
    protected $entityBodyNamePattern;

    /**
     * Строка которая добавляется перед  заготовкой имени сущности полученной в результате
     * примерения @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @var string
     */
    protected $entityNamePrefix;

    /**
     * Строка которая добавляется после заготовки имени сущности полученной в результате примерения
     * @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @var string
     */
    protected $entityNamePostfix;


    /**
     * Строка, используемая как разделитель в полном имени класса сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator)
     *
     * @return string
     */
    public function getEntitySeparator()
    {
        return $this->entitySeparator;
    }

    /**
     * Устанавливает строку используемую как разделитель в полном имени класса сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator)
     *
     * @param string $entitySeparator
     *
     * @return $this
     */
    public function setEntitySeparator($entitySeparator)
    {
        $this->entitySeparator = $entitySeparator;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getEntityBodyNamePattern()
    {
        return $this->entityBodyNamePattern;
    }

    /**
     * Устанавливает паттерн по которому из имени интерфейса можно получить строку,
     * являющеюся заготовкой для формирования имени сущности
     *
     * @param string $entityBodyNamePattern
     *
     * @return $this
     */
    public function setEntityBodyNamePattern($entityBodyNamePattern)
    {
        $this->entityBodyNamePattern = $entityBodyNamePattern;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getEntityNamePrefix()
    {
        return $this->entityNamePrefix;
    }

    /**
     * Устанавливает строку которая добавляется перед  заготовкой именем сущности полученной в результате
     * примерения @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @param string $entityNamePrefix
     *
     * @return $this
     */
    public function setEntityNamePrefix($entityNamePrefix)
    {
        $this->entityNamePrefix = $entityNamePrefix;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getEntityNamePostfix()
    {
        return $this->entityNamePostfix;
    }

    /**
     * Устанавливает строку которая добавляется после заготовки имени сущности полученной в результате примерения
     * @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @param string $entityNamePostfix
     *
     * @return $this
     */
    public function setEntityNamePostfix($entityNamePostfix)
    {
        $this->entityNamePostfix = $entityNamePostfix;

        return $this;
    }
}
