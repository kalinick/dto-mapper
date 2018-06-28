<?php

namespace MapperBundle\Mapping\Annotation;

/**
 * Interface DestinationMetaInterface
 */
interface DestinationMetaInterface extends PropertyRelationsInterface
{
    /**
     * @return bool
     */
    public function isDestinationClass(): bool;
}
