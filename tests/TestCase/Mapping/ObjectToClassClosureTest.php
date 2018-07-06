<?php

namespace Tests\TestCase\Mapping;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\TypeResolver;

use Tests\DataFixtures\Dto\DeepValueDto;
use Tests\DataFixtures\Model\Outer;

/**
 * Class ObjectToClassClosureTest
 */
class ObjectToClassClosureTest extends AbstractMapping
{
    /**
     * Source object, getter strategy test
     */
    public function testGetterHydration()
    {
        $outer = new Outer();
        $searchString = 'Returned from closure';
        $closure = function (Outer $outer) use ($searchString): string {
            return $outer->getInner()->getDeep()->getDeepValue() . $searchString;
        };

        $hydrator = $this->createClosureObjectHydrator(
            $outer,
            DeepValueDto::class,
            'test',
            $closure
        );

        /** @var DeepValueDto $dto */
        $dto = $hydrator->hydrate($outer, DeepValueDto::class);
        $this->assertContains($searchString, $dto->getTest());
    }

    /**
     * @param object   $source
     * @param string   $destinationClass
     * @param string   $destinationProperty
     * @param \Closure $closure
     *
     * @return HydratorInterface
     */
    private function createClosureObjectHydrator(
        object $source,
        string $destinationClass,
        string $destinationProperty,
        \Closure $closure
    ): HydratorInterface {
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
                $this->createClosureStrategy($closure)
            );

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))
            ->createHydrator($source, $destinationClass);
    }
}
