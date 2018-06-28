<?php

namespace MapperBundle\Mapping\Annotation\Meta;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class PropertyClassRelation extends Annotation
{
    /**
     * @Required
     */
    public $targetClass;

    /**
     * @var bool
     */
    public $multiply = false;

    /**
     * @return string
     */
    public function getTargetClass(): string
    {
        return $this->targetClass;
    }

    /**
     * @return bool
     */
    public function isMultiply(): bool
    {
        return $this->multiply;
    }
}
