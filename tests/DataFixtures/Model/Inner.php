<?php

namespace Tests\DataFixtures\Model;

/**
 * Class Inner
 */
class Inner
{
    /**
     * @var Deep
     */
    private $deep;

    public function __construct()
    {
        $this->deep = new Deep();
    }

    /**
     * @return Deep
     */
    public function getDeep(): Deep
    {
        return $this->deep;
    }
}
