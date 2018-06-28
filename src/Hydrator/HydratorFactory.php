<?php

namespace MapperBundle\Hydrator;

use MapperBundle\Mapping\MappingRegistry;

/**
 * Class HydratorFactory
 */
class HydratorFactory
{
    /**
     * @var HydratorRegistry
     */
    private $hydratorRegistry;

    /**
     * @var MappingRegistry
     */
    private $mappingRegistry;

    /**
     * HydratorFactory constructor.
     *
     * @param HydratorRegistry $hydratorRegistry
     * @param MappingRegistry  $mappingRegistry
     */
    public function __construct(HydratorRegistry $hydratorRegistry, MappingRegistry $mappingRegistry)
    {
        $this->hydratorRegistry = $hydratorRegistry;
        $this->mappingRegistry = $mappingRegistry;
    }

    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return HydratorBuilder
     */
    public function createBuilder($source, $destination): HydratorBuilder
    {
        $hydrator = $this->hydratorRegistry->getHydrator(HydratorRegistry::hydratorType($source, $destination));

        return HydratorBuilder::create($hydrator);
    }

    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return HydratorInterface
     */
    public function createHydrator($source, $destination): HydratorInterface
    {
        return $this->hydratorRegistry->getHydrator(HydratorRegistry::hydratorType($source, $destination));
    }
}
