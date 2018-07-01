<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class RelationsRequestDto
 */
class RelationsRequestDto
{
    /**
     * @var RegistrationRequestDto[]
     */
    public $registrationsRequests = [];

    /**
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
