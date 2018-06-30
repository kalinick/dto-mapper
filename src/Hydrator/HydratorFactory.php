<?php

namespace MapperBundle\Hydrator;

use MapperBundle\Hydrator\Strategy\StrategyInterface;
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
     * @return HydratorBuilderInterface
     */
    public function createHydratorBuilder($source, $destination): HydratorBuilderInterface
    {
        /** @var AbstractHydrator $hydrator */
        $hydrator = $this->hydratorRegistry->getHydrator($source, $destination);

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
        /** @var HydratorBuilderInterface $hBuilder */
        $hBuilder = $this->createHydrator($source, $destination);
        $hydrationStrategies = $this->mappingRegistry->getRegisteredStrategiesFor($source, $destination);
        $namingStrategy = $this->mappingRegistry->getRegisteredNamingStrategyFor($destination);

        if ($namingStrategy !== null) {
            $hBuilder->setNamingStrategy($namingStrategy);
        }

        /** @var StrategyInterface $strategy */
        foreach ($hydrationStrategies as $name => $strategy) {
            $hBuilder->addStrategy($name, $strategy);
        }

        return $hBuilder->getHydrator();
    }
}
