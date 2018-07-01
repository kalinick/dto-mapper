<?php

namespace Tests\TestCase\Mapping;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\TypeDict;
use DataMapper\TypeResolver;
use Tests\DataFixtures\Dto\RegistrationRequestDto;

/**
 * Class ArrayToDtoMappingTest
 */
class ArrayToDtoMappingTest extends AbstractMapping
{
    /**
     * @param array $registrationData
     *
     * @dataProvider registrationDataProvider
     */
    public function testArrayToDtoMapping(array $registrationData): void
    {
        /** @var RegistrationRequestDto $dto */
        $dto = $this
            ->createArrayToClassHydrator(
                $registrationData,
                RegistrationRequestDto::class
            )
            ->hydrate(
                $registrationData,
                RegistrationRequestDto::class
            );

        $this->assertEquals($dto->getFirstName(), $registrationData['first_name']);
        $this->assertEquals($dto->getLastName(), $registrationData['last_name']);
        $this->assertEquals($dto->getPassword(), $registrationData['password']);
        $this->assertEquals($dto->getCity(), $registrationData['city']);
        $this->assertEquals($dto->getCountry(), $registrationData['country']);
        $this->assertEquals($dto->getEmail(), $registrationData['email']);
        $this->assertEquals($dto->getBirthday(), $registrationData['birthday']);
        $this->assertEquals($dto->getPersonalInfo(), $registrationData['personal_info']);
    }

    /**
     * @return array
     */
    public function registrationDataProvider(): array
    {
        return [
            [
                [
                    'first_name' => 'Ivan',
                    'last_name' => 'Ivanov',
                    'password' => 'ivanstrongpassword',
                    'city' => 'Kiev',
                    'country' => 'Ukraine',
                    'email' => 'ivan@gmail.com',
                    'birthday' => '2020/02//12',
                    'personal_info' => [
                        'a_a' => 1,
                        'b_b' => 2,
                    ]
                ],
            ],
            [
                [
                    'first_name' => null,
                    'last_name' => 2,
                    'password' => 'ivanstrongpassword',
                    'city' => null,
                    'country' => 'Ukraine',
                    'email' => 'ivan@gmail.com',
                    'birthday' => '2020/02//12',
                    'personal_info' => [
                        'a_a' => 1,
                        'b_b' => 2,
                    ]
                ],
            ],
        ];
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
}
