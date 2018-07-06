<?php

namespace Tests\TestCase\Mapping;

use DataMapper\Hydrator\{
    ExtractionInterface,
    NamingStrategy\NamingStrategyInterface,
    NamingStrategy\SnakeCaseNamingStrategy,
    NamingStrategy\UnderscoreNamingStrategy,
    Strategy\ClosureStrategy,
    Strategy\CollectionStrategy,
    Strategy\StrategyInterface,
    Strategy\GetterStrategy,
    HydratorInterface,
    HydratorRegistry,
    CollectionHydrator,
    AbstractHydrator,
    ArraySerializableHydrator,
    ObjectHydrator,
    Strategy\XPathGetterStrategy
};

use DataMapper\Mapper\{
    MappingRegistry,
    Registry\DestinationRegistry,
    Registry\NamingStrategyRegistry,
    Registry\RelationsRegistry,
    Registry\RelationsRegistryInterface,
    Registry\StrategyRegistry,
    Registry\StrategyRegistryInterface
};

use DataMapper\TypeDict;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractMapping
 */
abstract class AbstractMapping extends TestCase
{
    /**
     * @param StrategyRegistryInterface $registry
     *
     * @return HydratorRegistry
     */
    protected function createHydrationRegistry(StrategyRegistryInterface $registry): HydratorRegistry
    {
        $collectionHydrator = $this->createCollectionHydrator();
        $objectHydrator = $this->createObjectHydrator($registry);
        $arraySerializerHydrator = $this->createArraySerializableHydrator();

        $hydrationRegistry = new HydratorRegistry();
        $hydrationRegistry->registerHydrator($collectionHydrator, TypeDict::ARRAY_TO_CLASS);
        $hydrationRegistry->registerHydrator($collectionHydrator, TypeDict::ARRAY_TO_OBJECT);
        $hydrationRegistry->registerHydrator($collectionHydrator, TypeDict::OBJECT_TO_ARRAY);
        $hydrationRegistry->registerHydrator($arraySerializerHydrator, TypeDict::ARRAY_TO_ARRAY);
        $hydrationRegistry->registerHydrator($objectHydrator, TypeDict::OBJECT_TO_CLASS);
        $hydrationRegistry->registerHydrator($objectHydrator, TypeDict::OBJECT_TO_OBJECT);

        return $hydrationRegistry;
    }

    /**
     * @return AbstractHydrator
     */
    protected function createCollectionHydrator(): AbstractHydrator
    {
        return new CollectionHydrator();
    }

    /**
     * @return AbstractHydrator
     */
    protected function createArraySerializableHydrator(): AbstractHydrator
    {
        return new ArraySerializableHydrator();
    }

    /**
     * @param StrategyRegistryInterface $registry
     *
     * @return AbstractHydrator
     */
    protected function createObjectHydrator(StrategyRegistryInterface $registry): AbstractHydrator
    {
        return new ObjectHydrator($registry);
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
     * @param HydratorInterface $hydrator
     * @param RelationsRegistryInterface $registry
     *
     * @return StrategyInterface
     */
    protected function createCollectionStrategy(
        HydratorInterface $hydrator,
        RelationsRegistryInterface $registry
    ): StrategyInterface {
        return new CollectionStrategy($hydrator, $registry);
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
     * @param string $methodName
     *
     * @return GetterStrategy
     */
    protected function createGetterStrategy(string $methodName): GetterStrategy
    {
        return new GetterStrategy($methodName);
    }

    /**
     * @param \Closure $closure
     *
     * @return ClosureStrategy
     */
    protected function createClosureStrategy(\Closure $closure): ClosureStrategy
    {
        return new ClosureStrategy($closure);
    }

    /**
     * @param ExtractionInterface $extractor
     * @param string              $path
     *
     * @return XPathGetterStrategy
     */
    protected function createXPathStrategy(ExtractionInterface $extractor, string $path): XPathGetterStrategy
    {
        return new XPathGetterStrategy($extractor, $path);
    }
}
