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
     * @var int
     */
    private $destinationGetterTarget = 100;

    /**
     * @var string
     */
    public $copiedByName = 'ok';

    public $found;
    public $test;

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

    /**
     * @return int
     */
    public function getTestGetter(): int
    {
        return $this->destinationGetterTarget;
    }

    /**
     * @return string
     */
    public function getCopiedByName(): string
    {
        return $this->copiedByName;
    }
}
