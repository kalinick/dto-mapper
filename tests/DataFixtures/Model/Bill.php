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
     * @var string
     */
    private $copiedByName = 'ok';

    /**
     * @return string
     */
    public function getFormattedAmount(): string
    {
        return $this->amount . ' USD';
    }

    /**
     * @return string
     */
    public function getCopiedByName(): string
    {
        return $this->copiedByName;
    }
}
