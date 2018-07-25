<?php

namespace DataMapper\Strategy;

use DataMapper\Exception\InvalidArgumentException;
use DataMapper\MapperInterface;
use DataMapper\MappingRegistry\RelationsRegistryInterface;

/**
 * Class MultiCollectionStrategy
 */
class CollectionStrategy implements StrategyInterface
{
    /**
     * @var RelationsRegistryInterface
     */
    private $mappingRegistry;

    /**
     * @var MapperInterface
     */
    private $mapper;

    /**
     * CollectionStrategy constructor.
     *
     * @param MapperInterface            $mapper
     * @param RelationsRegistryInterface $mappingRegistry
     */
    public function __construct(MapperInterface $mapper, RelationsRegistryInterface $mappingRegistry)
    {
        $this->mappingRegistry = $mappingRegistry;
        $this->mapper = $mapper;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($value, $context)
    {
        if (!\is_array($context) && \is_object($value)) {
            return $value;
        }

        [$sourceContext, $propertyName] = $context;

        if (!\is_object($sourceContext)) {
            throw new InvalidArgumentException('$sourceContextClass - argument must be object.');
        }

        $sourceContextClass = \get_class($sourceContext);
        $hasRelation = $this->mappingRegistry->hasRegisteredRelation($propertyName, $sourceContextClass);

        if (!$hasRelation) {
            return $value;
        }
        $relationTargetClass = $this->mappingRegistry->getRegisteredRelation($propertyName, $sourceContextClass);

        if (\is_object($value)) {
            return $this->mapper->convert($value, $relationTargetClass);
        }
        $hasMultiRelation = $this
            ->mappingRegistry
            ->hasRegisteredMultiRelation($propertyName, $sourceContextClass);

        if (\is_array($value) && false === $hasMultiRelation) {
             return $value;
        }

        return \array_map(
            function ($element) use ($relationTargetClass) {
                return $this->mapper->convert($element, $relationTargetClass);
            },
            $value
        );
    }
}
