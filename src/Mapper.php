<?php

namespace DataMapper;

use DataMapper\Hydrator\HydratorFactoryInterface;
use DataMapper\Type\TypeDict;

/**
 * Class Mapper
 */
class Mapper implements MapperInterface
{
    /**
     * @var HydratorFactoryInterface
     */
    private $hydratorFactory;

    /**
     * Mapper constructor.
     *
     * @param HydratorFactoryInterface $hydratorFactory
     */
    public function __construct(HydratorFactoryInterface $hydratorFactory)
    {
        $this->hydratorFactory = $hydratorFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function convert($source, $destination)
    {
        if (null === $source || !(\is_object($source) || \is_array($source))) {
            return $source;
        }

        gc_enable();

        $dto = $this
            ->hydratorFactory
            ->createHydrator($source, $destination)
            ->hydrate($source, $destination);

        gc_collect_cycles();

        return $dto;
    }

    /**
     * TODO: double check mapper usage then swap return to yield
     *
     * {@inheritDoc}
     */
    public function convertCollection(iterable $sources, string $destination): iterable
    {
        $result = [];

        foreach ($sources as $key => $source) {
            $result[$key] = $this->convert($source, $destination);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function extract(object $source): array
    {
        return $this
            ->hydratorFactory
            ->createHydrator($source, TypeDict::ARRAY_TYPE)
            ->extract($source);
    }
}
