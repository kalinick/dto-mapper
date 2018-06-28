<?php

namespace Tests\TestCase\Mapper\ArrayMapping;

use MapperBundle\Hydrator\NamingStrategy\SnakeCaseNamingStrategy;
use PHPUnit\Framework\TestCase;
use Tests\DataFixtures\Dto\Destination\RegistrationRequestDto;
use Tests\TestCase\Mapper\MapperTrait;

/**
 * Class ArrayToDtoMappingTest
 */
class ArrayToDtoMappingTest extends TestCase
{
    use MapperTrait;

    /**
     * @param array $registrationData
     *
     * @dataProvider registrationDataProvider
     */
    public function testArrayToDtoMapping(array $registrationData)
    {
        $namingStrategy = new SnakeCaseNamingStrategy();
        /** @var RegistrationRequestDto $dto */
        $dto = $this->createMapper($namingStrategy)->convert($registrationData, RegistrationRequestDto::class);
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
            ]
        ];
    }
}
