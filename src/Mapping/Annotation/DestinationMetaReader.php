<?php

namespace MapperBundle\Mapping\Annotation;

use Doctrine\Common\Annotations\Reader;
use MapperBundle\Mapping\Annotation\Exception\UndeclaredPropertyException;
use MapperBundle\Mapping\Annotation\Meta\DestinationClass;
use MapperBundle\Mapping\Annotation\Meta\PropertyClassRelation;

/**
 * Class DestinationMetaReader
 */
class DestinationMetaReader implements DestinationMetaInterface
{
    /**
     * @var bool
     */
    private $isDestinationClass = false;

    /**
     * @var PropertyClassRelation[]
     */
    private $relationsProperties = [];

    /**
     * DestinationMetaReader constructor.
     *
     * @param Reader $reader
     * @param string $className
     */
    private function __construct(Reader $reader, string $className)
    {
        $reflectionClass = new \ReflectionClass($className);
        $this->isDestinationClass = (bool) $reader->getClassAnnotation($reflectionClass, DestinationClass::class);
        $reflectionProperties = $reflectionClass->getProperties();

        foreach ($reflectionProperties as $property) {
            /** @var PropertyClassRelation $mapperProperty */
            if (!$mapperProperty = $reader->getPropertyAnnotation($property, PropertyClassRelation::class)) {
                continue;
            }

            $this->relationsProperties[$property->getName()] = $mapperProperty;
        }
    }

    /**
     * @param Reader $reader
     * @param string $className
     *
     * @return DestinationMetaReader
     */
    public static function read(Reader $reader, string $className): self
    {
        return new self($reader, $className);
    }

    /**
     * {@inheritDoc}
     */
    public function isDestinationClass(): bool
    {
        return $this->isDestinationClass;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPropertyRelations(): bool
    {
        return (bool) count($this->relationsProperties);
    }

    /**
     * {@inheritDoc}
     */
    public function hasMultiRelations(string $propertyName): bool
    {
        return $this->hasPropertyRelation($propertyName) ?
            $this->loadPropertyRelation($propertyName)->isMultiply() :
            false;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPropertyRelation(string $propertyName): bool
    {
        return isset($this->relationsProperties[$propertyName]);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyTarget(string $propertyName): string
    {
        return $this->loadPropertyRelation($propertyName)->getTargetClass();
    }

    /**
     * @throws UndeclaredPropertyException
     *
     * @param string $propertyName
     *
     * @return PropertyClassRelation
     */
    private function loadPropertyRelation(string $propertyName): PropertyClassRelation
    {
        if (isset($this->relationsProperties[$propertyName]) === false) {
            throw new UndeclaredPropertyException('Property: ' . $propertyName . ' has no target binding');
        }

        return $this->relationsProperties[$propertyName];
    }
}
