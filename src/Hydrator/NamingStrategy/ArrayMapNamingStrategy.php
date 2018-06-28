<?php

namespace MapperBundle\Hydrator\NamingStrategy;

/**
 * Class ArrayMapNamingStrategy
 */
final class ArrayMapNamingStrategy implements NamingStrategyInterface
{
    /**
     * @var string[]
     */
    private $extractionMap = [];

    /**
     * @var string[]
     */
    private $hydrationMap = [];

    /**
     * Constructor
     *
     * @param array $extractionMap A map of string keys and values for symmetric translation of hydrated
     *                             and extracted field names
     */
    public function __construct(array $extractionMap)
    {
        $this->extractionMap = $extractionMap;
        $this->hydrationMap  = array_flip($extractionMap);
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate(string $name): string
    {
        return isset($this->hydrationMap[$name]) ? $this->hydrationMap[$name] : $name;
    }

    /**
     * {@inheritDoc}
     */
    public function extract(string $name): string
    {
        return isset($this->extractionMap[$name]) ? $this->extractionMap[$name] : $name;
    }
}
