<?php

namespace DataMapper\Mapper\Registry;

use DataMapper\Hydrator\Strategy\StrategyInterface;
use DataMapper\Mapper\MappingRegistry;
use DataMapper\Mapping\Exception\MappingRegistryException;

/**
 * Trait StrategyRegistryTrait
 */
trait StrategyRegistryTrait
{
    /**
     * @var array
     */
    protected $strategyRegistry = [];

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredTypeStrategy(string $source, string $destination): bool
    {
        $key = $this->formatKey($source, $destination);

        return isset($this->strategyRegistry[$key][MappingRegistry::ALL_STRATEGY]);
    }

    /**
     * {@inheritDoc}
     */
    public function hasRegisteredPropertyStrategy(string $source, string $destination, string $property): bool
    {
        if (!$this->hasRegisteredTypeStrategy($source, $destination)) {
            return false;
        }
        $key = $this->formatKey($source, $destination);

        return isset($this->strategyRegistry[$key][$property]);
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisteredStrategiesFor(string $source, string $destination): array
    {
        $key = $this->formatKey($source, $destination);

        return $this->hasRegisteredTypeStrategy($source, $destination) ?
            $this->strategyRegistry[$key] : [];
    }

    /**
     * {@inheritDoc}
     */
    public function registerPropertyStrategy(
        string $source,
        string $destination,
        string $property,
        StrategyInterface $strategy
    ): void {
        if ($this->hasRegisteredPropertyStrategy($source, $destination, $property)) {
            throw new MappingRegistryException("Property strategy already registered for: 
                source $source, destination: $destination, property $property
            ");
        }

        $key = $this->formatKey($source, $destination);
        $this->strategyRegistry[$key][$property] = $strategy;
    }

    /**
     * {@inheritDoc}
     */
    public function registerTypeStrategy(string $source, string $destination, StrategyInterface $strategy): void
    {
        if ($this->hasRegisteredTypeStrategy($source, $destination)) {
            $message = "Type strategy already registered for: source $source, destination: $destination";

            throw new MappingRegistryException($message);
        }
        $key = $this->formatKey($source, $destination);
        $this->strategyRegistry[$key][MappingRegistry::ALL_STRATEGY] = $strategy;
    }

    /**
     * {@inheritDoc}
     */
    public function getMapperPropertiesKeys(string $source, string $destination): array
    {
        return \array_keys($this->getRegisteredStrategiesFor($source, $destination));
    }

    /**
     * @param string $source
     * @param string $destination
     *
     * @return string
     */
    private function formatKey(string $source, string $destination): string
    {
        return $source . '#' . $destination;
    }
}
