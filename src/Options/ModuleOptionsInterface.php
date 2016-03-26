<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Options;

/**
 * Interface ModuleOptionsInterface
 *
 * @package Nnx\Doctrine\Options
 */
interface ModuleOptionsInterface
{
    /**
     * Строка, используемая как разделитель в полном имени класса сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator)
     *
     * @return string
     */
    public function getEntitySeparator();

    /**
     * Возвращает паттерн по которому из имени интерфейса можно получить строку,
     * являющеюся заготовкой для формирования имени сущности
     *
     * @return string
     */
    public function getEntityBodyNamePattern();

    /**
     * Возвращает строку которая добавляется перед  заготовкой именем сущности полученной в результате
     * примерения @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @return string
     */
    public function getEntityNamePrefix();


    /**
     * Возвращает строку которая добавляется после заготовки имени сущности полученной в результате примерения
     * @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @return string
     */
    public function getEntityNamePostfix();
}
