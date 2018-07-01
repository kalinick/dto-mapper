<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\Mapping\Exception\MappingRegistryException;

/**
 * Trait RelationsRegistryTrait
 */
trait RelationsRegistryTrait
{
    /**
     * @var array
     */
    protected $registeredRelationsMapping = [];

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredRelationsMapping(string $className): bool
    {
        return isset($this->registeredRelationsMapping[$className]);
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredRelationDestination(string $propertyName, string $destinationClass): bool
    {
        $hasRelations = $this->hasRegisteredRelationsMapping($destinationClass) ?
            isset($this->registeredRelationsMapping[$destinationClass][$propertyName]) :
            false;

        return $hasRelations;
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredMultiRelationsDestination(string $propertyName, string $destinationClass): bool
    {
        $isMulti = $this->hasRegisteredRelationDestination($propertyName, $destinationClass) ?
            $this->registeredRelationsMapping[$destinationClass][$propertyName]['multi'] :
            false;

        return $isMulti;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisteredRelationDestination(string $propertyName, string $destinationClass): string
    {
        if (!$this->hasRegisteredRelationDestination($propertyName, $destinationClass)) {
            $message = "No registered relation mapping for class: $destinationClass, property: $propertyName";

            throw new MappingRegistryException($message);
        }

        return $this->registeredRelationsMapping[$destinationClass][$propertyName]['target'];
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

        if (!$this->hasRegisteredRelationDestination($propertyName, $destinationClass)) {
            $message = "Relation Mapping already registered for class: $destinationClass, property: $propertyName";

            throw new MappingRegistryException($message);
        }

        $this->registeredRelationsMapping[$destinationClass][$propertyName] = [
            'target' => $targetClass,
            'multi' => $isMulti,
        ];
    }
}
