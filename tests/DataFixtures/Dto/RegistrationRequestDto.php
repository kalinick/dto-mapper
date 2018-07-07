<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class RegistrationRequestDto
 */
class RegistrationRequestDto
{
    public $firstName;
    public $lastName;
    public $password;
    public $city;
    public $country;
    public $email;
    public $birthday;
    public $personalInfo = [];

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return array
     */
    public function getPersonalInfo(): array
    {
        return $this->personalInfo;
    }
}
