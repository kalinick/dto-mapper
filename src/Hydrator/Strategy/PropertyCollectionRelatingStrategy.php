<?php

namespace MapperBundle\Hydrator\Strategy;

use MapperBundle\Hydrator\HydratorInterface;
use MapperBundle\Mapping\MappingRegistry;

/**
 * Class PropertyRelationsStrategy
 */
class PropertyCollectionRelatingStrategy implements StrategyInterface
{
    /**
     * @var MappingRegistry
     */
    private $mappingRegistry;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * PropertyRelationsStrategy constructor.
     *
     * @param HydratorInterface $hydrator
     * @param MappingRegistry   $mappingRegistry
     */
    public function __construct(HydratorInterface $hydrator, MappingRegistry $mappingRegistry)
    {
        $this->mappingRegistry = $mappingRegistry;
        $this->hydrator = $hydrator;
    }

    /**
     * {@inheritDoc}
     */
    public function extract($value, $context): array
    {
        $this->hydrator->extract($value);
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate(string $propertyName, string $destination, $value)
    {
        if (!is_array($value) || !$this->mappingRegistry->hasRegisteredRelationsMapping($destination)) {
            return $value;
        }

        $relations = $this->mappingRegistry->loadRelationsMapping($destination);
        if ($relations->hasMultiRelations($propertyName)) {
            $value = array_map(function($element) use ($relations, $propertyName) {
                $destination = $relations->getPropertyTarget($propertyName);

                return $this->hydrator->hydrate($element, $destination);
            }, $value);

        } else if ($relations->hasPropertyRelation($propertyName)) {
            $value = $this->hydrator->hydrate($value, $relations->getPropertyTarget($propertyName));
        }

        return $value;
    }
}
