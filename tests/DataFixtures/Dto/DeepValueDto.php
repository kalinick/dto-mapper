<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class DeepValueDto
 */
class DeepValueDto
{
    public $found;
    public $test;
    public $destinationGetterTarget;
    public $copiedByName;
    public $inner;

    public function getFound()
    {
        return $this->found;
    }

    /**
     * @return mixed
     */
    public function getInner()
    {
        return $this->inner;
    }

    public function getTest()
    {
        return $this->test;
    }

    public function getDestinationGetterTarget()
    {
        return $this->destinationGetterTarget;
    }

    public function getCopiedByName()
    {
        return $this->copiedByName;
    }
}
