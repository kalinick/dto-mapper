<?php

namespace DataMapper\Hydrator;

use DataMapper\MappingRegistry\HydratorRegistryInterface;
use DataMapper\MappingRegistry\MappingRegistryInterface;
use DataMapper\Type\TypeResolver;

/**
 * Class HydratorFactory
 */
class HydratorFactory implements HydratorFactoryInterface
{
    /**
     * @var HydratorRegistryInterface
     */
    private $hydratorRegistry;

    /**
     * @var MappingRegistryInterface
     */
    private $mappingRegistry;

    /**
     * HydratorFactory constructor.
     *
     * @param HydratorRegistryInterface $hydratorRegistry
     * @param MappingRegistryInterface  $mappingRegistry
     */
    public function __construct(HydratorRegistryInterface $hydratorRegistry, MappingRegistryInterface $mappingRegistry)
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
