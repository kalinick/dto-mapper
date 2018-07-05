<?php

namespace Tests\TestCase\Mapping;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\TypeDict;
use DataMapper\TypeResolver;

use Tests\DataFixtures\Dto\DeepValueDto;
use Tests\DataFixtures\Model\Outer;

/**
 * Class ObjectToClassXPathTest
 */
class ObjectToClassXPathTest extends AbstractMapping
{
    /**
     * Source object, getter strategy test
     */
    public function testGetterHydration()
    {
        $outer = new Outer();
        $pathTOValue = 'inner.deep.searchValue';
        $hydrator = $this->createXPathObjectHydrator(
            $outer,
            DeepValueDto::class,
            ['found', $pathTOValue]
        );
        /** @var DeepValueDto $dto */
        $dto = $hydrator->hydrate($outer, DeepValueDto::class);
        $this->assertEquals($dto->getFound(), $outer->getInner()->getDeep()->getDeepValue());
    }

    /**
     * @param object $source
     * @param string $destinationClass
     * @param array  $mapping
     *
     * @return HydratorInterface
     */
    private function createXPathObjectHydrator(
        object $source,
        string $destinationClass,
        array $mapping
    ): HydratorInterface {
        [$destinationProperty, $path] = $mapping;
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry($mappingRegistry->getStrategyRegistry());
        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass($destinationClass);


        $mappingRegistry
            ->getStrategyRegistry()
            ->registerPropertyStrategy(
                TypeResolver::getStrategyType($source, $destinationClass),
                $destinationProperty,
                $this->createXPathStrategy(
                    $hydrationRegistry->getHydratorByType(TypeDict::OBJECT_TO_CLASS),
                    $path
                )
            );

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))
            ->createHydrator($source, $destinationClass);
    }
}
