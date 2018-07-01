<?php

namespace DataMapper\Hydrator;

use DataMapper\Mapper\MappingRegistry;

/**
 * Class HydratorFactory
 */
class HydratorFactory implements HydratorFactoryInterface
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
     * {@inheritDoc}
     */
    public function createHydratorBuilder($source, $destination): HydratorBuilderInterface
    {
        /** @var AbstractHydrator $hydrator */
        $hydrator = $this->hydratorRegistry->getHydrator($source, $destination);

        return HydratorBuilder::create($hydrator);
    }

    /**
     * {@inheritDoc}
     */
    public function createHydrator($source, $destination): HydratorInterface
    {
        $hBuilder = $this->createHydratorBuilder($source, $destination);
        $hydrationStrategies = $this->mappingRegistry->getRegisteredStrategiesFor($source, $destination);

        if ($namingStrategy = $this->mappingRegistry->getRegisteredNamingStrategyFor($destination)) {
            $hBuilder->setNamingStrategy($namingStrategy);
        }

        foreach ($hydrationStrategies as $name => $strategy) {
            $hBuilder->addStrategy($name, $strategy);
        }

        return $hBuilder->getHydrator();
    }
}
