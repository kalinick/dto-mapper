<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class DeepValueDto
 */
class DeepValueDto
{
    /**
     * @var string|null
     */
    public $found;

    /**
     * @var mixed
     */
    public $test;

    /**
     * @return string|null
     */
    public function getFound(): ?string
    {
        return $this->found;
    }

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }
}
