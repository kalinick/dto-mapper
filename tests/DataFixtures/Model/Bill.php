<?php

namespace Tests\DataFixtures\Model;

/**
 * Class Bill
 */
class Bill
{
    /**
     * @var int
     */
    private $amount = 10;

    /**
     * @return string
     */
    public function getFormattedAmount(): string
    {
        return $this->amount . ' USD';
    }
}
