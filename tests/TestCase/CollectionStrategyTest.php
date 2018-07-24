<?php

namespace Tests\TestCase;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\Mapper;
use DataMapper\MapperInterface;
use DataMapper\Strategy\ClosureStrategy;
use DataMapper\Strategy\CollectionStrategy;
use DataMapper\Type\TypeDict;
use DataMapper\Type\TypeResolver;

use Tests\DataFixtures\Dto\AgeDto;
use Tests\DataFixtures\Dto\HumanDto;
use Tests\DataFixtures\Dto\WeightDto;
use Tests\DataFixtures\Model\CollectionRoot;
use Tests\DataFixtures\Traits\BaseMappingTrait;

use PHPUnit\Framework\TestCase;

/**
 * Class CollectionStrategyTest
 */
class CollectionStrategyTest extends TestCase
{
    use BaseMappingTrait;

    /**
     */
    public function testObjectConvert(): void
    {
        $source = new CollectionRoot();
        $mapper = $this->createMapper();
        /** @var HumanDto $dto */
        $dto = $mapper->convert($source, HumanDto::class);
        $this->assertInstanceOf(HumanDto::class, $dto);
        $this->assertInstanceOf(AgeDto::class, $dto->nodeB);
        $this->assertInstanceOf(WeightDto::class, $dto->nodeA);
        $this->assertContainsOnlyInstancesOf(AgeDto::class, $dto->nodeC);
    }

    /**
     *
     * @return MapperInterface
     */
    protected function createMapper(): MapperInterface
    {
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry();
        $relationsRegistry = $mappingRegistry->getRelationsRegistry();
        $factory = new HydratorFactory($hydrationRegistry, $mappingRegistry);
        $mapper = new Mapper($factory);

        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass(HumanDto::class);

        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass(WeightDto::class);

        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass(AgeDto::class);

        $relationsRegistry->registerRelationsMapping(
            'nodeA',
            CollectionRoot::class,
            WeightDto::class,
            false
        );

        $relationsRegistry->registerRelationsMapping(
            'nodeB',
            CollectionRoot::class,
            AgeDto::class,
            false
        );

        $relationsRegistry->registerRelationsMapping(
            'nodeC',
            CollectionRoot::class,
            AgeDto::class,
            true
        );

        $mappingRegistry
            ->getStrategyRegistry()
            ->registerPropertyStrategy(
                TypeResolver::getStrategyType(CollectionRoot::class, HumanDto::class),
                'nodeA',
                new CollectionStrategy($mapper, $relationsRegistry)
            );

        $mappingRegistry
            ->getStrategyRegistry()
            ->registerPropertyStrategy(
                TypeResolver::getStrategyType(CollectionRoot::class, HumanDto::class),
                'nodeB',
                new CollectionStrategy($mapper, $relationsRegistry)
            );

        $mappingRegistry
            ->getStrategyRegistry()
            ->registerPropertyStrategy(
                TypeResolver::getStrategyType(CollectionRoot::class, TypeDict::ALL_TYPE),
                'nodeC',
                new CollectionStrategy($mapper, $relationsRegistry)
            );


        return $mapper;
    }

}
