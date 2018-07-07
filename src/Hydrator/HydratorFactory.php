<?php

namespace DataMapper\Hydrator;

use DataMapper\MappingRegistry\HydratorRegistry;
use DataMapper\MappingRegistry\MappingRegistry;
use DataMapper\Type\TypeResolver;

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
        $type = TypeResolver::getHydratedType($source, $destination);
        $hydrator = $this->hydratorRegistry->getHydratorByType($type);

        return HydratorBuilder::create($hydrator);
    }

    /**
     * {@inheritDoc}
     */
    public function createHydrator($source, $destination): HydratorInterface
    {
        $hBuilder = $this->createHydratorBuilder($source, $destination);
        $strategyKey = TypeResolver::getStrategyType($source, $destination);
        $hydrationStrategies = $this
            ->mappingRegistry
            ->getStrategyRegistry()
            ->loadRegisteredStrategiesFor($strategyKey);

        $namingStrategy = $this
            ->mappingRegistry
            ->getNamingRegistry()
            ->getRegisteredNamingStrategyFor($strategyKey);

        if ($namingStrategy !== null) {
            $hBuilder->setNamingStrategy($namingStrategy);
        }

        foreach ($hydrationStrategies as $name => $strategy) {
            $hBuilder->addStrategy($name, $strategy);
        }

        return $hBuilder->getHydrator();
    }
}
