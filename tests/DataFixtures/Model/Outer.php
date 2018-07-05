<?php

namespace Tests\DataFixtures\Model;

/**
 * Class Outer
 */
class Outer
{
    /**
     * @var Inner
     */
    private $inner;

    /**
     * Outer constructor.
     */
    public function __construct()
    {
        $this->inner = new Inner();
    }

    /**
     * @return Inner
     */
    public function getInner(): Inner
    {
        return $this->inner;
    }
}
