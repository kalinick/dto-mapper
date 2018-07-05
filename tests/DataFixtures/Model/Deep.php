<?php

namespace Tests\DataFixtures\Model;

/**
 * Class Deep
 */
class Deep
{
    private $searchValue = 'find me';
    /**
     * @return string
     */
    public function getDeepValue(): string
    {
        return $this->searchValue;
    }
}
