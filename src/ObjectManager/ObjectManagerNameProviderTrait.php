<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ObjectManager;

/**
 * Class ObjectManagerNameProviderTrait
 *
 * @package Nnx\Doctrine\ObjectManager
 */
trait ObjectManagerNameProviderTrait
{
    /**
     * Имя используемого ObjectManager'a
     *
     * @var string
     */
    protected $objectManagerName = 'doctrine.entitymanager.orm_default';

    /**
     * Возвращает имя используемого ObjectManager'a
     *
     * @return string
     *
     * @throws Exception\RuntimeException
     */
    public function getObjectManagerName()
    {
        if (!is_string($this->objectManagerName)) {
            $errMsg = 'Invalid object manager name. Manager name not string.';
            throw new Exception\InvalidObjectManagerNameException($errMsg);
        }
        return $this->objectManagerName;
    }

    /**
     * Устанавливает имя используемого ObjectManager
     *
     * @param string $objectManagerName
     *
     * @return $this
     */
    public function setObjectManagerName($objectManagerName)
    {
        $this->objectManagerName = $objectManagerName;

        return $this;
    }
}
