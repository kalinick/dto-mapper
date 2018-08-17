<?php

namespace Tests\DataFixtures\Traits;

use DataMapper\Hydrator;
use DataMapper\NamingStrategy;
use DataMapper\MappingRegistry;
use DataMapper\Type\TypeDict;

/**
 * Class AbstractMapping
 */
trait BaseMappingTrait
{
    /**
     * @return MappingRegistry\HydratorRegistry
     */
    protected function createHydrationRegistry(): MappingRegistry\HydratorRegistry
    {
        $objectHydrator = $this->createObjectHydrator();
        $arraySerializerHydrator = $this->createArraySerializableHydrator();
        $arrayCollectionHydrator = $this->createArrayCollectionHydrator();

        $hydrationRegistry = new MappingRegistry\HydratorRegistry();
        $hydrationRegistry->registerHydrator($arrayCollectionHydrator, TypeDict::ARRAY_TO_CLASS);
        $hydrationRegistry->registerHydrator($arrayCollectionHydrator, TypeDict::ARRAY_TO_OBJECT);
        $hydrationRegistry->registerHydrator($arraySerializerHydrator, TypeDict::OBJECT_TO_ARRAY);
        $hydrationRegistry->registerHydrator($arraySerializerHydrator, TypeDict::ARRAY_TO_ARRAY);
        $hydrationRegistry->registerHydrator($objectHydrator, TypeDict::OBJECT_TO_CLASS);
        $hydrationRegistry->registerHydrator($objectHydrator, TypeDict::OBJECT_TO_OBJECT);

        return $hydrationRegistry;
    }

    /**
     * @return Hydrator\AbstractHydrator
     */
    protected function createObjectHydrator(): Hydrator\AbstractHydrator
    {
        return new Hydrator\ObjectHydrator();
    }

    /**
     * @return Hydrator\AbstractHydrator
     */
    protected function createArraySerializableHydrator(): Hydrator\AbstractHydrator
    {
        return new Hydrator\ArraySerializableHydrator();
    }

    /**
     * @return Hydrator\AbstractHydrator
     */
    protected function createArrayCollectionHydrator(): Hydrator\AbstractHydrator
    {
        return new Hydrator\ArrayCollectionHydrator();
    }

    /**
     * @return MappingRegistry\MappingRegistry
     */
    protected function createMappingRegistry(): MappingRegistry\MappingRegistry
    {
        return new MappingRegistry\MappingRegistry(
            new MappingRegistry\ClassMappingRegistry(),
            new MappingRegistry\NamingStrategyRegistry(),
            new MappingRegistry\StrategyRegistry()
        );
    }

    /**
     * @return NamingStrategy\NamingStrategyInterface
     */
    protected function createUnderscoreNamingStrategy(): NamingStrategy\NamingStrategyInterface
    {
        return new NamingStrategy\UnderscoreNamingStrategy();
    }

    /**
     * @return NamingStrategy\SnakeCaseNamingStrategy
     */
    protected function createSnakeCaseNamingStrategy(): NamingStrategy\NamingStrategyInterface
    {
        return new NamingStrategy\SnakeCaseNamingStrategy();
    }

    /**
     * @param array      $mapping
     * @param array|null $reverse
     *
     * @return NamingStrategy\NamingStrategyInterface
     */
    protected function createMapNamingStrategy(
        array $mapping,
        ?array $reverse
    ): NamingStrategy\NamingStrategyInterface {
        return new NamingStrategy\MapNamingStrategy($mapping, $reverse);
    }
}
