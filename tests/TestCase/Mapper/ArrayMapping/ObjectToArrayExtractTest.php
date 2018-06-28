<?php

namespace Tests\TestCase\Mapper\ArrayMapping;

use MapperBundle\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use PHPUnit\Framework\TestCase;
use Tests\DataFixtures\Dto\Destination\RegistrationResponseDto;
use Tests\TestCase\Mapper\MapperTrait;

/**
 * Class ObjectToArrayExtractTest
 */
class ObjectToArrayExtractTest extends TestCase
{
    use MapperTrait;

    /**
     * @test
     */
    public function tesObjectToUnderscoreArrayExtraction()
    {
        $namingStrategy = new UnderscoreNamingStrategy();
        $mapper = $this->createMapper($namingStrategy);
        $dto = new RegistrationResponseDto();
        $extraxted = $mapper->extract($dto);
        $this->assertEquals($dto->getFirstName(), $extraxted['first_name']);
        $this->assertEquals($dto->getLastName(), $extraxted['last_name']);
        $this->assertEquals($dto->getPassword(), $extraxted['password']);
        $this->assertEquals($dto->getCity(), $extraxted['city']);
        $this->assertEquals($dto->getCountry(), $extraxted['country']);
        $this->assertEquals($dto->getEmail(), $extraxted['email']);
        $this->assertEquals($dto->getBirthday(), $extraxted['birthday']);
        $this->assertEquals($dto->getPersonalInfo(), $extraxted['personal_info']);
    }
}
