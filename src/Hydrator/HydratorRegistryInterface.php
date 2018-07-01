<?php

namespace DataMapper\Hydrator;

use DataMapper\Hydrator\Exception\{
    DuplicateTypeException,
    UnknownHydratorTypeException
};

/**
 * Interface HydratorRegistryInterface
 */
interface HydratorRegistryInterface
{
    /**
     * @throws UnknownHydratorTypeException
     *
     * @param string $type
     *
     * @return AbstractHydrator
     */
    public function getHydratorByType(string $type): AbstractHydrator;

    /**
     * @throws DuplicateTypeException
     *
     * @param AbstractHydrator $hydrator
     * @param string           $type
     *
     * @return HydratorRegistryInterface
     */
    public function registerHydrator(AbstractHydrator $hydrator, string $type): HydratorRegistryInterface;

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasRegisterHydrator(string $type): bool;
}
