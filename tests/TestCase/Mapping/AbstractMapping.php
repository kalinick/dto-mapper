<?php

namespace Tests\TestCase\Mapping;

use DataMapper\Hydrator\{
    NamingStrategy\NamingStrategyInterface,
    NamingStrategy\SnakeCaseNamingStrategy,
    NamingStrategy\UnderscoreNamingStrategy,
    Strategy\CollectionStrategy,
    Strategy\StrategyInterface,
    HydratorInterface,
    HydratorFactory,
    HydratorRegistry,
    CollectionHydrator,
    AbstractHydrator,
    ArraySerializableHydrator,
    ObjectHydrator
};

use DataMapper\Mapper\{
    MappingRegistry,
    Registry\RelationsRegistryInterface,
    Registry\StrategyRegistryInterface
};

use DataMapper\TypeDict;
use DataMapper\TypeResolver;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractMapping
 */
abstract class AbstractMapping extends TestCase
{
    /**
     * @param array  $source
     * @param string $className
     * @param array  $mappingProps
     *
     * @return HydratorInterface
     */
    protected function createArrayToClassCollectionHydrator(
        array $source,
        string $className,
        array $mappingProps
    ): HydratorInterface {
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry($mappingRegistry->getStrategyRegistry());
        $relationsRegistry = $mappingRegistry->getRelationsRegistry();

        foreach ($mappingProps as [$prop, $target, $multi]) {
            $relationsRegistry->registerRelationsMapping($prop, $className, $target, $multi);
        }

        $collectionStrategy = $this->createCollectionStrategy(
            $hydrationRegistry->getHydratorByType(TypeDict::ARRAY_TO_CLASS),
            $relationsRegistry
        );

        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass($className);

        $mappingRegistry
            ->getNamingRegistry()
            ->registerNamingStrategy(
                $className,
                $this->createSnakeCaseNamingStrategy()
            );

        $strategyKey = TypeResolver::getStrategyType($source, $className);
        $mappingRegistry
            ->getStrategyRegistry()
            ->registerTypeStrategy($strategyKey, $collectionStrategy);

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))
            ->createHydrator($source, $className);
    }

    /**
     * @param array  $source
     * @param string $className
     *
     * @return HydratorInterface
     */
    protected function createArrayToClassHydrator(array $source, string $className): HydratorInterface
    {
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry($mappingRegistry->getStrategyRegistry());

        $collectionStrategy = $this->createCollectionStrategy(
            $hydrationRegistry->getHydratorByType(TypeDict::ARRAY_TO_CLASS),
            $mappingRegistry->getRelationsRegistry()
        );

        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass($className);

        $mappingRegistry
            ->getNamingRegistry()
            ->registerNamingStrategy(
                $className,
                $this->createSnakeCaseNamingStrategy()
            );

        $strategyKey = TypeResolver::getStrategyType($source, $className);
        $mappingRegistry
            ->getStrategyRegistry()
            ->registerTypeStrategy($strategyKey, $collectionStrategy);

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))
            ->createHydrator($source, $className);
    }

    /**
     * @param StrategyRegistryInterface $registry
     *
     * @return HydratorRegistry
     */
    private function createHydrationRegistry(StrategyRegistryInterface $registry): HydratorRegistry
    {
        $collectionHydrator = $this->createCollectionHydrator();
        $objectHydrator = $this->createObjectHydrator($registry);
        $arraySerializerHydrator = $this->createArraySerializableHydrator();

        $hydrationRegistry = new HydratorRegistry();
        $hydrationRegistry->registerHydrator($collectionHydrator, TypeDict::ARRAY_TO_CLASS);
        $hydrationRegistry->registerHydrator($collectionHydrator, TypeDict::ARRAY_TO_OBJECT);
        $hydrationRegistry->registerHydrator($arraySerializerHydrator, TypeDict::ARRAY_TO_ARRAY);
        $hydrationRegistry->registerHydrator($objectHydrator, TypeDict::OBJECT_TO_CLASS);
        $hydrationRegistry->registerHydrator($objectHydrator, TypeDict::OBJECT_TO_OBJECT);

        return $hydrationRegistry;
    }

    /**
     * @return AbstractHydrator
     */
    private function createCollectionHydrator(): AbstractHydrator
    {
        return new CollectionHydrator();
    }

    /**
     * @return AbstractHydrator
     */
    private function createArraySerializableHydrator(): AbstractHydrator
    {
        return new ArraySerializableHydrator();
    }

    /**
     * @param StrategyRegistryInterface $registry
     *
     * @return AbstractHydrator
     */
    private function createObjectHydrator(StrategyRegistryInterface $registry): AbstractHydrator
    {
        return new ObjectHydrator($registry);
    }

    /**
     * @return MappingRegistry
     */
    private function createMappingRegistry(): MappingRegistry
    {
        return new MappingRegistry();
    }

    /**
     * @param HydratorInterface $hydrator
     * @param RelationsRegistryInterface $registry
     *
     * @return StrategyInterface
     */
    private function createCollectionStrategy(
        HydratorInterface $hydrator,
        RelationsRegistryInterface $registry
    ): StrategyInterface {
        return new CollectionStrategy($hydrator, $registry);
    }
    /**
     * @return NamingStrategyInterface
     */
    private function createUnderscoreNamingStrategy(): NamingStrategyInterface
    {
        return new UnderscoreNamingStrategy();
    }

    /**
     * @return SnakeCaseNamingStrategy
     */
    private function createSnakeCaseNamingStrategy(): NamingStrategyInterface
    {
        return new SnakeCaseNamingStrategy();
    }
}
