<?php

namespace Tests\TestCase\Mapping;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\TypeDict;
use DataMapper\TypeResolver;
use Tests\DataFixtures\Dto\PersonalInfoDto;
use Tests\DataFixtures\Dto\RegistrationRequestDto;
use Tests\DataFixtures\Dto\RelationsRequestDto;

/**
 * Class ArrayToRelatedDtoMappingTest
 */
class ArrayToRelatedDtoMappingTest extends AbstractMapping
{
    /**
     * @param array $parameters
     * @param array $relations
     *
     * @dataProvider registrationDataProvider
     */
    public function testArrayToDtoMapping(array $parameters, array $relations): void
    {
        /** @var RelationsRequestDto $dto */
        $dto = $this
            ->createArrayToClassCollectionHydrator(
                $parameters,
                RelationsRequestDto::class,
                $relations

            )
            ->hydrate($parameters, RelationsRequestDto::class);

        $this->assertRegistrationData($parameters['registrations_requests'][0], $dto->getRegistrationsRequests()[0]);
        $this->assertRegistrationData($parameters['registrations_requests'][1], $dto->getRegistrationsRequests()[1]);
        $this->assertEquals($parameters['personal_info']['code_word'], $dto->getPersonalInfo()->getCodeWord());
        $this->assertEquals($parameters['personal_info']['gender'], $dto->getPersonalInfo()->getGender());
        $this->assertEquals($parameters['personal_info']['phone'], $dto->getPersonalInfo()->getPhone());
        $this->assertEquals($parameters['extra'], $dto->getExtra());
    }

    /**
     * @param array                  $registrationData
     * @param RegistrationRequestDto $dto
     */
    private function assertRegistrationData(array $registrationData, RegistrationRequestDto $dto): void
    {
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
                    'registrations_requests' => [
                        [
                            'first_name' => 'Ivan 1',
                            'last_name' => 'Ivanov 1',
                            'password' => 'ivanstrongpassword 1',
                            'city' => 'Kiev 1',
                            'country' => 'Ukraine 1',
                            'email' => 'ivan@gmail.com 1',
                            'birthday' => '2020/02//12 1',
                            'personal_info' => [
                                'a_a' => 1,
                                'b_b' => 2,
                            ]
                        ],
                        [
                            'first_name' => 'Ivan 2',
                            'last_name' => 'Ivanov 2',
                            'password' => 'ivanstrongpassword 2',
                            'city' => 'Kiev 2',
                            'country' => 'Ukraine 2',
                            'email' => 'ivan@gmail.com 2',
                            'birthday' => '2020/02//12 2',
                            'personal_info' => [
                                'a_a' => 1,
                                'b_b' => 2,
                            ]
                        ],
                    ],
                    'personal_info' => [
                        'code_word' => 'secret',
                        'gender' => 'male',
                        'phone' => 'xxxxxxxx',
                    ],
                    'extra' => [
                        'extra_1' => 1,
                        'extra_2' => 2,
                    ]
                ],
                [
                    [
                        'registrationsRequests',
                        RegistrationRequestDto::class,
                        true,
                    ],
                    [
                        'personalInfo',
                        PersonalInfoDto::class,
                        false
                    ]
                ]
            ]
        ];
    }

    /**
     * @param array  $source
     * @param string $className
     * @param array  $mappingProps
     *
     * @return HydratorInterface
     */
    protected function createArrayToClassCollectionHydrator(
        array $source,
        string $className,
        array $mappingProps
    ): HydratorInterface {
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry($mappingRegistry->getStrategyRegistry());
        $relationsRegistry = $mappingRegistry->getRelationsRegistry();

        foreach ($mappingProps as [$prop, $target, $multi]) {
            $relationsRegistry->registerRelationsMapping($prop, $className, $target, $multi);
        }

        $collectionStrategy = $this->createCollectionStrategy(
            $hydrationRegistry->getHydratorByType(TypeDict::ARRAY_TO_CLASS),
            $relationsRegistry
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
