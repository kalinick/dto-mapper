<?php

namespace DataMapper;

use DataMapper\Hydrator\HydratorInterface;

/**
 * Trait HydratorAwareTrait
 */
trait HydratorAwareTrait
{
    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * @param  HydratorInterface $hydrator
     *
     * @return self
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;

        return $this;
    }

    /**
     * @return null|HydratorInterface
     */
    public function getHydrator(): ?HydratorInterface
    {
        return $this->hydrator;
    }
}
