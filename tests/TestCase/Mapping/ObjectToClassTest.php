<?php

namespace Tests\TestCase\Mapping;

use DataMapper\Hydrator\AbstractHydrator;
use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\TypeDict;

use DataMapper\TypeResolver;
use Tests\DataFixtures\Dto\CustomerDto;
use Tests\DataFixtures\Model\Bill;

/**
 * Class ObjectToClassTest
 */
class ObjectToClassTest extends AbstractMapping
{
    /**
     * Source object, getter strategy test
     */
    public function testGetterHydration()
    {
        $bill = new Bill();
        $hydrator = $this->createGetterObjectHydrator($bill, CustomerDto::class, ['bill', 'getFormattedAmount']);
        /** @var CustomerDto $dto */
        $dto = $hydrator->hydrate($bill, CustomerDto::class);
        $this->assertEquals($dto->getBill(), $bill->getFormattedAmount());
    }

    /**
     * @param object $source
     * @param string $destinationClass
     * @param array  $mapping
     *
     * @return HydratorInterface
     */
    private function createGetterObjectHydrator(
        object $source,
        string $destinationClass,
        array $mapping
    ): HydratorInterface {
        [$destinationProperty, $sourceGetterName] = $mapping;
        $mappingRegistry = $this->createMappingRegistry();
        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass($destinationClass);

        $mappingRegistry
            ->getStrategyRegistry()
            ->registerPropertyStrategy(
                TypeResolver::getStrategyType($source, $destinationClass),
                $destinationProperty,
                $this->createGetterStrategy($sourceGetterName)
            );
        $hydrationRegistry = $this->createHydrationRegistry($mappingRegistry->getStrategyRegistry());

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))
            ->createHydrator($source, $destinationClass);
    }
}
