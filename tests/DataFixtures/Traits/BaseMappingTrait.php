<?php

namespace Tests\DataFixtures\Traits;

use DataMapper\Hydrator\AbstractHydrator;
use DataMapper\Hydrator\ArrayCollectionHydrator;
use DataMapper\Hydrator\ArraySerializableHydrator;
use DataMapper\Hydrator\ObjectHydrator;
use DataMapper\MappingRegistry\DestinationRegistry;
use DataMapper\MappingRegistry\HydratorRegistry;
use DataMapper\MappingRegistry\MappingRegistry;
use DataMapper\MappingRegistry\NamingStrategyRegistry;
use DataMapper\MappingRegistry\RelationsRegistry;
use DataMapper\MappingRegistry\StrategyRegistry;
use DataMapper\NamingStrategy\NamingStrategyInterface;
use DataMapper\NamingStrategy\SnakeCaseNamingStrategy;
use DataMapper\NamingStrategy\UnderscoreNamingStrategy;
use DataMapper\Type\TypeDict;

/**
 * Class AbstractMapping
 */
trait BaseMappingTrait
{
    /**
     * @return HydratorRegistry
     */
    protected function createHydrationRegistry(): HydratorRegistry
    {
        $objectHydrator = $this->createObjectHydrator();
        $arraySerializerHydrator = $this->createArraySerializableHydrator();
        $arrayCollectionHydrator = $this->createArrayCollectionHydrator();

        $hydrationRegistry = new HydratorRegistry();
        $hydrationRegistry->registerHydrator($arrayCollectionHydrator, TypeDict::ARRAY_TO_CLASS);
        $hydrationRegistry->registerHydrator($arrayCollectionHydrator, TypeDict::ARRAY_TO_OBJECT);
        $hydrationRegistry->registerHydrator($arraySerializerHydrator, TypeDict::OBJECT_TO_ARRAY);
        $hydrationRegistry->registerHydrator($arraySerializerHydrator, TypeDict::ARRAY_TO_ARRAY);
        $hydrationRegistry->registerHydrator($objectHydrator, TypeDict::OBJECT_TO_CLASS);
        $hydrationRegistry->registerHydrator($objectHydrator, TypeDict::OBJECT_TO_OBJECT);

        return $hydrationRegistry;
    }

    /**
     * @return AbstractHydrator
     */
    protected function createObjectHydrator(): AbstractHydrator
    {
        return new ObjectHydrator();
    }

    /**
     * @return AbstractHydrator
     */
    protected function createArraySerializableHydrator(): AbstractHydrator
    {
        return new ArraySerializableHydrator();
    }

    /**
     * @return AbstractHydrator
     */
    protected function createArrayCollectionHydrator(): AbstractHydrator
    {
        return new ArrayCollectionHydrator();
    }

    /**
     * @return MappingRegistry
     */
    protected function createMappingRegistry(): MappingRegistry
    {
        return new MappingRegistry(
            new DestinationRegistry(),
            new RelationsRegistry(),
            new NamingStrategyRegistry(),
            new StrategyRegistry()
        );
    }

    /**
     * @return NamingStrategyInterface
     */
    protected function createUnderscoreNamingStrategy(): NamingStrategyInterface
    {
        return new UnderscoreNamingStrategy();
    }

    /**
     * @return SnakeCaseNamingStrategy
     */
    protected function createSnakeCaseNamingStrategy(): NamingStrategyInterface
    {
        return new SnakeCaseNamingStrategy();
    }
}
