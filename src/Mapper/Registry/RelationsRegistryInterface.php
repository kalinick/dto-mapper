<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\Exception\MappingRegistryException;

/**
 * Interface RelationsRegistryInterface
 */
interface RelationsRegistryInterface
{
    /**
     * @param string $className
     *
     * @return bool
     */
    public function hasRegisteredRelations(string $className): bool;

    /**
     * @param string $propertyName
     * @param string $className
     *
     * @return bool
     */
    public function hasRegisteredRelation(string $propertyName, string $className): bool;

    /**
     * @param string $propertyName
     * @param string $destinationClass
     *
     * @return bool
     */
    public function hasRegisteredMultiRelation(string $propertyName, string $destinationClass): bool;

    /**
     * @throws MappingRegistryException
     *
     * @param string $propertyName
     * @param string $destinationClass
     *
     * @return string
     */
    public function getRegisteredRelation(string $propertyName, string $destinationClass): string;

    /**
     * @throws MappingRegistryException
     *
     * @param string $propertyName
     * @param string $destinationClass
     * @param string $targetClass
     * @param bool   $isMulti
     *
     * @return void
     */
    public function registerRelationsMapping(
        string $propertyName,
        string $destinationClass,
        string $targetClass,
        bool $isMulti = false
    ): void;
}
