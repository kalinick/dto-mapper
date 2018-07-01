<?php

namespace DataMapper\Hydrator\Strategy;

use DataMapper\Hydrator\Exception\InvalidArgumentException;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\Mapper\Registry\CollectionRelationsRegistryInterface;

/**
 * Class MultiCollectionStrategy
 */
final class CollectionStrategy implements StrategyInterface
{
    /**
     * @var CollectionRelationsRegistryInterface
     */
    private $mappingRegistry;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * CollectionStrategy constructor.
     *
     * @param HydratorInterface                      $hydrator
     * @param CollectionRelationsRegistryInterface   $mappingRegistry
     */
    public function __construct(HydratorInterface $hydrator, CollectionRelationsRegistryInterface $mappingRegistry)
    {
        $this->mappingRegistry = $mappingRegistry;
        $this->hydrator = $hydrator;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($value, $context)
    {
        if (!\is_array($value)) {
            return $value;
        }
        [$contextClass, $propertyName] = $context;

        if (!\is_string($contextClass) || !\class_exists($contextClass)) {
            throw new InvalidArgumentException('$context - argument must be exists class name');
        }
        $hasRelation = $this->mappingRegistry->hasRegisteredRelationDestination($propertyName, $contextClass);

        if (!$hasRelation) {
            return $value;
        }

        $relationTargetClass = $this
            ->mappingRegistry
            ->getRegisteredRelationDestination($propertyName, $contextClass);

        $hasMultiRelation = $this
            ->mappingRegistry
            ->hasRegisteredMultiRelationsDestination($propertyName, $contextClass);

        if (!$hasMultiRelation) {
            return $this->hydrator->hydrate($value, $relationTargetClass);
        }

        return \array_map(
            function ($element) use ($relationTargetClass) {
                    return $this->hydrator->hydrate($element, $relationTargetClass);
            },
            $value
        );
    }
}
