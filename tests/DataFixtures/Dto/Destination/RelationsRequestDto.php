<?php

namespace Tests\DataFixtures\Dto\Destination;

use MapperBundle\Mapping\Annotation\Meta\PropertyClassRelation;
use MapperBundle\Mapping\Annotation\Meta\DestinationClass;

/**
 * Class RelationsRequestDto
 * @DestinationClass
 */
class RelationsRequestDto
{
    /**
     * @PropertyClassRelation(targetClass="Tests\DataFixtures\Dto\Destination\RegistrationRequestDto", multiply="true")
     *
     * @var RegistrationRequestDto[]
     */
    public $registrationsRequests = [];

    /**
     * @PropertyClassRelation(targetClass="Tests\DataFixtures\Dto\Destination\PersonalInfoDto")
     *
     * @var PersonalInfoDto
     */
    public $personalInfo;

    /**
     * @var array
     */
    public $extra = [];

    /**
     * @return RegistrationRequestDto[]
     */
    public function getRegistrationsRequests(): array
    {
        return $this->registrationsRequests;
    }

    /**
     * @return PersonalInfoDto
     */
    public function getPersonalInfo(): PersonalInfoDto
    {
        return $this->personalInfo;
    }

    /**
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }
}
