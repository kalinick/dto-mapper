<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class HumanDto
 */
class HumanDto
{
    /**
     * @var WeightDto
     */
    public $nodeA;

    /**
     * @var AgeDto
     */
    public $nodeB;

    /**
     * @var AgeDto[]
     */
    public $nodeC = [];
}
