<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class CustomerDto
 */
class CustomerDto
{
    /**
     * @var string
     */
    private $bill = '00.00';

    /**
     * @return string
     */
    public function getBill(): string
    {
        return $this->bill;
    }
}
