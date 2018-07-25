<?php

namespace DataMapper\Strategy;

use DataMapper\Exception\InvalidArgumentException;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\MappingRegistry\RelationsRegistryInterface;

/**
 * Class SerializerStrategy
 */
class SerializerStrategy implements StrategyInterface
{
    /**
     * @var RelationsRegistryInterface
     */
    private $mappingRegistry;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * CollectionStrategy constructor.
     *
     * @param HydratorInterface          $hydrator
     * @param RelationsRegistryInterface $mappingRegistry
     */
    public function __construct(HydratorInterface $hydrator, RelationsRegistryInterface $mappingRegistry)
    {
        $this->mappingRegistry = $mappingRegistry;
        $this->hydrator = $hydrator;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($value, $context)
    {
        if (!\is_array($value) || !\is_array($context)) {
            return $value;
        }

        [$destinationContextClass, $propertyName] = $context;

        if (\is_object($destinationContextClass)) {
            $destinationContextClass = \get_class($destinationContextClass);
        }

        if (!\is_string($destinationContextClass) || !\class_exists($destinationContextClass)) {
            throw new InvalidArgumentException('$destinationContextClass - argument must be exists class name');
        }

        if (false === $this->mappingRegistry->hasRegisteredRelation($propertyName, $destinationContextClass)) {
            return $value;
        }

        $relationTargetClass = $this
            ->mappingRegistry
            ->getRegisteredRelation($propertyName, $destinationContextClass);

        $hasMultiRelation = $this
            ->mappingRegistry
            ->hasRegisteredMultiRelation($propertyName, $destinationContextClass);

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
