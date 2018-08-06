<?php

namespace Tests\TestCase;

use DataMapper\Hydrator\HydratorFactory;
use DataMapper\Hydrator\HydratorInterface;
use DataMapper\Mapper;
use DataMapper\MapperInterface;
use DataMapper\Type\TypeResolver;
use PHPUnit\Framework\TestCase;
use Tests\DataFixtures\Dto\RegistrationRequestDto;
use Tests\DataFixtures\Traits\BaseMappingTrait;

/**
 * Class ConvertCollectionTest
 */
class ConvertCollectionTest extends TestCase
{
    use BaseMappingTrait;

    /**
     * @dataProvider registrationCollectionDataProvider
     *
     * @param iterable $newUsers
     */
    public function testCollectionConvertation(iterable $newUsers): void
    {
        $mapper = $this->createMapper($newUsers, RegistrationRequestDto::class);
        $result = $mapper->convertCollection($newUsers, RegistrationRequestDto::class);
        $this->assertContainsOnlyInstancesOf(RegistrationRequestDto::class, $result);
    }

    /**
     * @return array
     */
    public function registrationCollectionDataProvider(): array
    {
        return [
            [
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
                        ],
                    ],
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
                        ],
                    ],
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
                        ],
                    ],
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
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param array  $source
     * @param string $className
     *
     * @return MapperInterface
     */
    protected function createMapper(array $source, string $className): MapperInterface
    {
        $mappingRegistry = $this->createMappingRegistry();
        $hydrationRegistry = $this->createHydrationRegistry();
        $strategyKey = TypeResolver::getStrategyType($source, $className);

        $mappingRegistry
            ->getDestinationRegistry()
            ->registerDestinationClass($className);

        $mappingRegistry
            ->getNamingRegistry()
            ->registerNamingStrategy($strategyKey, $this->createSnakeCaseNamingStrategy());

        return new Mapper(new HydratorFactory($hydrationRegistry, $mappingRegistry));
    }
}
