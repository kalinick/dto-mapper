<?php

namespace Tests\TestCase;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\Strategy\XPathGetterStrategy;
use DataMapper\Type\TypeDict;
use DataMapper\Type\TypeResolver;

use Tests\DataFixtures\Dto\DeepValueDto;
use Tests\DataFixtures\Model\Outer;
use Tests\DataFixtures\Traits\BaseMappingTrait;

use PHPUnit\Framework\TestCase;

/**
 * Class ObjectToClassXPathTest
 */
class ObjectToClassXPathTest extends TestCase
{
    use BaseMappingTrait;

    /**
     * Source object, getter strategy test
     */
    public function testXPathHydration(): void
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
        $this->assertEquals($dto->getCopiedByName(), $outer->getCopiedByName());
    }

    /**
     * @param object $source
     * @param string $target
     * @param array  $mapping
     *
     * @return HydratorInterface
     */
    private function createXPathObjectHydrator(object $source, string $target, array $mapping): HydratorInterface
    {
        [$destinationProperty, $path] = $mapping;
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry();
        $strategyKey = TypeResolver::getStrategyType($source, $target);
        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass($target);

        $mappingRegistry
            ->getStrategyRegistry()
            ->registerPropertyStrategy(
                $strategyKey,
                $destinationProperty,
                new XPathGetterStrategy(
                    $hydrationRegistry->getHydratorByType(TypeDict::OBJECT_TO_CLASS),
                    $path
                )
            );

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))->createHydrator($source, $target);
    }
}
