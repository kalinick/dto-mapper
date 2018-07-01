<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\Exception\MappingRegistryException;
use DataMapper\RegistryContainer;

/**
 * Class RelationsRegistry
 */
class RelationsRegistry extends RegistryContainer implements RelationsRegistryInterface
{
    /**
     * {@inheritDoc}
     */
    public function hasRegisteredRelations(string $className): bool
    {
        return $this->offsetExists($className);
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredRelation(string $propertyName, string $className): bool
    {
        return $this->offsetExists($className) ? isset($this->offsetGet($className)[$propertyName]) : false;
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredMultiRelation(string $propertyName, string $destinationClass): bool
    {
        return $this->hasRegisteredRelation($propertyName, $destinationClass) ?
            $this->offsetGet($destinationClass)[$propertyName]['multi'] : false;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisteredRelation(string $propertyName, string $destinationClass): string
    {
        return $this->offsetGet($destinationClass)[$propertyName]['target'];
    }

    /**
     * {@inheritDoc}
     */
    public function registerRelationsMapping(
        string $propertyName,
        string $destinationClass,
        string $targetClass,
        bool $isMulti = false
    ): void {
        if ($this->hasRegisteredRelation($propertyName, $destinationClass)) {
            $message = "Relation Mapping already registered for class: $destinationClass, property: $propertyName";
            throw new MappingRegistryException($message);
        }

        $value = [];
        if ($this->offsetExists($destinationClass)) {
            $value = $this->offsetGet($destinationClass);
        }

        $value[$propertyName] = [
            'target' => $targetClass,
            'multi' => $isMulti,
        ];

        $this->offsetSet($destinationClass, $value);
    }
}
