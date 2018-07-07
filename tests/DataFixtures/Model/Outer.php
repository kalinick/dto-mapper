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
    private $testGetter = 100;

    /**
     * @var string
     */
    public $copiedByName = 'ok';


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
        return $this->testGetter;
    }

    /**
     * @return string
     */
    public function getCopiedByName(): string
    {
        return $this->copiedByName;
    }
}
