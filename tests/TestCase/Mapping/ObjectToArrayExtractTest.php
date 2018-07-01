<?php

namespace Tests\TestCase\Mapping;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\TypeDict;

use Tests\DataFixtures\Dto\RegistrationResponseDto;

/**
 * Class ObjectToArrayExtractTest
 */
class ObjectToArrayExtractTest extends AbstractMapping
{
    /**
     * Test extraction values from object using hydrated naming strategy
     */
    public function testObjectToUnderscoreArrayExtraction(): void
    {
        $dto = new RegistrationResponseDto();
        $hydrator = $this->createObjectToArrayHydrator($dto);
        $extracted = $hydrator->extract($dto);

        $this->assertEquals($dto->getFirstName(), $extracted['first_name']);
        $this->assertEquals($dto->getLastName(), $extracted['last_name']);
        $this->assertEquals($dto->getPassword(), $extracted['password']);
        $this->assertEquals($dto->getCity(), $extracted['city']);
        $this->assertEquals($dto->getCountry(), $extracted['country']);
        $this->assertEquals($dto->getEmail(), $extracted['email']);
        $this->assertEquals($dto->getBirthday(), $extracted['birthday']);
        $this->assertEquals($dto->getPersonalInfo(), $extracted['personal_info']);
    }

    /**
     * @param object $source
     *
     * @return HydratorInterface
     */
    protected function createObjectToArrayHydrator(object $source): HydratorInterface
    {
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry($mappingRegistry->getStrategyRegistry());

        $mappingRegistry
            ->getNamingRegistry()
            ->registerNamingStrategy(
                TypeDict::ARRAY_TYPE,
                $this->createUnderscoreNamingStrategy()
            );

        return (new HydratorFactory($hydrationRegistry, $mappingRegistry))
            ->createHydrator($source, []);
    }
}
