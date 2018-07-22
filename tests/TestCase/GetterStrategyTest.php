<?php

namespace Tests\TestCase;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\Strategy\GetterStrategy;
use DataMapper\Type\TypeResolver;

use Tests\DataFixtures\Dto\CustomerDto;
use Tests\DataFixtures\Model\Bill;
use Tests\DataFixtures\Traits\BaseMappingTrait;

use PHPUnit\Framework\TestCase;

/**
 * Class GetterStrategyTest
 */
class GetterStrategyTest extends TestCase
{
    use BaseMappingTrait;

    /**
     */
    public function testGetterStrategyHydration(): void
    {
        $bill = new Bill();
        $hydrator = $this->createHydrator($bill, CustomerDto::class, ['bill', 'getFormattedAmount']);
        /** @var CustomerDto $dto */
        $dto = $hydrator->hydrate($bill, CustomerDto::class);
        $this->assertEquals($dto->getBill(), $bill->getFormattedAmount());
        $this->assertEquals($dto->getCopiedByName(), $bill->getCopiedByName());
    }

    /**
     * @param object $source
     * @param string $destinationClass
     * @param array  $mapping
     *
     * @return HydratorInterface
     */
    private function createHydrator(object $source, string $destinationClass, array $mapping): HydratorInterface
    {
        [$destinationProperty, $sourceGetterName] = $mapping;
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry();
        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass($destinationClass);

        $mappingRegistry
            ->getStrategyRegistry()
            ->registerPropertyStrategy(
                TypeResolver::getStrategyType($source, $destinationClass),
                $destinationProperty,
                new GetterStrategy($sourceGetterName)
            );

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))
            ->createHydrator($source, $destinationClass);
    }
}
