<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class PersonalInfoDto
 */
class PersonalInfoDto
{
    public $codeWord;
    public $gender;
    public $phone;

    /**
     * @return mixed
     */
    public function getCodeWord()
    {
        return $this->codeWord;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
