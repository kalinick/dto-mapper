<?php

namespace Tests\DataFixtures\Traits;

use DataMapper\Hydrator\{
    AbstractHydrator,
    ArrayCollectionHydrator,
    ArraySerializableHydrator,
    ObjectHydrator
};
use DataMapper\NamingStrategy\{
    MapNamingStrategy, NamingStrategyInterface, SnakeCaseNamingStrategy, UnderscoreNamingStrategy
};
use DataMapper\MappingRegistry\{
    DestinationRegistry, HydratorRegistry, MappingRegistry,
    NamingStrategyRegistry, RelationsRegistry, StrategyRegistry
};
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

    /**
     * @param array      $mapping
     * @param array|null $reverse
     *
     * @return NamingStrategyInterface
     */
    protected function createMapNamingStrategy(array $mapping, ?array $reverse): NamingStrategyInterface
    {
        return new MapNamingStrategy($mapping, $reverse);
    }
}
