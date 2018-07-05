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
     * @return string|null
     */
    public function getFound(): ?string
    {
        return $this->found;
    }
}
