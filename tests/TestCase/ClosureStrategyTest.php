<?php

namespace Tests\TestCase;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\Strategy\ClosureStrategy;
use DataMapper\Type\TypeResolver;

use Tests\DataFixtures\Dto\DeepValueDto;
use Tests\DataFixtures\Model\Outer;
use Tests\DataFixtures\Traits\BaseMappingTrait;

use PHPUnit\Framework\TestCase;

/**
 * Class ClosureStrategyTest
 */
class ClosureStrategyTest extends TestCase
{
    use BaseMappingTrait;

    /**
     */
    public function testClosureStrategyHydration()
    {
        $outer = new Outer();
        $searchString = 'Returned from closure';
        $closure = function (Outer $outer) use ($searchString): string {
            return $outer->getInner()->getDeep()->getDeepValue() . $searchString;
        };

        $hydrator = $this->createHydrator(
            $outer,
            DeepValueDto::class,
            'test',
            [$closure]
        );

        /** @var DeepValueDto $dto */
        $dto = $hydrator->hydrate($outer, DeepValueDto::class);
        $this->assertContains($searchString, $dto->getTest());
        $this->assertEquals($dto->getCopiedByName(), $outer->getCopiedByName());
    }

    /**
     * @param object   $source
     * @param string   $target
     * @param string   $property
     * @param array    $args
     *
     * @return HydratorInterface
     */
    private function createHydrator(object $source, string $target, string $property, array $args): HydratorInterface
    {
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry();
        $strategyKey = TypeResolver::getStrategyType($source, $target);

        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass($target);

        $mappingRegistry
            ->getStrategyRegistry()
            ->registerPropertyStrategy($strategyKey, $property, ClosureStrategy::class, $args);

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))->createHydrator($source, $target);
    }
}
