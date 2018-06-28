<?php

namespace MapperBundle\Hydrator;

use MapperBundle\Hydrator\Exception\UnknownStrategyTypeException;
use MapperBundle\Hydrator\NamingStrategy\NamingStrategyEnabledInterface;
use MapperBundle\Hydrator\NamingStrategy\NamingStrategyInterface;
use MapperBundle\Hydrator\Strategy\StrategyEnabledInterface;
use MapperBundle\Hydrator\Strategy\StrategyInterface;

/**
 * Class AbstractHydrator
 */
abstract class AbstractHydrator implements HydratorInterface, StrategyEnabledInterface, NamingStrategyEnabledInterface
{
    /**
     * The list with strategies that this hydrator has.
     *
     * @var \ArrayObject
     */
    protected $strategies;

    /**
     * @var NamingStrategyInterface|null
     */
    protected $namingStrategy;

    /**
     * Initializes a new instance of this class.
     */
    public function __construct()
    {
        $this->strategies = new \ArrayObject();
    }

    /**
     * Checks if the strategy with the given name exists.
     *
     * @param string $name The name of the strategy to check for.
     *
     * @return bool
     */
    public function hasStrategy(string $name): bool
    {
        if (array_key_exists($name, $this->strategies)) {
            return true;
        }

        return array_key_exists('*', $this->strategies);
    }

    /**
     * Adds the given strategy under the given name.
     *
     * @param string            $name     The name of the strategy to register.
     * @param StrategyInterface $strategy The strategy to register.
     *
     * @return StrategyEnabledInterface
     */
    public function addStrategy(string $name, StrategyInterface $strategy): StrategyEnabledInterface
    {
        $this->strategies[$name] = $strategy;

        return $this;
    }

    /**
     * Removes the strategy with the given name.
     *
     * @param string $name The name of the strategy to remove.
     *
     * @return StrategyEnabledInterface
     */
    public function removeStrategy(string $name): StrategyEnabledInterface
    {
        unset($this->strategies[$name]);

        return $this;
    }

    /**
     * @throws UnknownStrategyTypeException
     *
     * @param string $name
     *
     * @return StrategyInterface
     */
    public function getStrategy(string $name): StrategyInterface
    {
        if (!$this->hasStrategy($name)) {
            throw new UnknownStrategyTypeException($name);
        }

        return $this->strategies[$name];
    }


    /**
     * Converts a value for extraction. If no strategy exists the plain value is returned.
     *
     * @param  string $name   The name of the strategy to use.
     * @param  mixed  $value  The value that should be converted.
     * @param  mixed  $object The object is optionally provided as context.
     *
     * @return mixed
     */
    public function extractValue(string $name, $value, $object = null)
    {
        if ($this->hasStrategy($name)) {
            $strategy = $this->getStrategy($name);
            $value = $strategy->extract($value, $object);
        }

        return $value;
    }


    /**
     * @param string $name
     * @param string $propertyName
     * @param string $destination
     * @param mixed  $value
     *
     * @return mixed
     */
    public function hydrateValue(string $name, string $propertyName, string $destination, $value)
    {
        if ($this->hasStrategy($name)) {
            $strategy = $this->getStrategy($name);
            $value = $strategy->hydrate($propertyName, $destination, $value);
        }

        return $value;
    }

    /**
     * Convert a name for extraction. If no naming strategy exists, the plain value is returned.
     *
     * @param string $name   The name to convert.
     * @param null   $object The object is optionally provided as context.
     *
     * @return string
     */
    public function extractName(string $name, $object = null): string
    {
        if ($this->hasNamingStrategy()) {
            $name = $this->getNamingStrategy()->extract($name, $object);
        }

        return $name;
    }

    /**
     * Converts a value for hydration. If no naming strategy exists, the plain value is returned.
     *
     * @param string $name The name to convert.
     * @param array  $data The whole data is optionally provided as context.
     *
     * @return string
     */
    public function hydrateName(string $name, $data = null): string
    {
        if ($this->hasNamingStrategy()) {
            $name = $this->getNamingStrategy()->hydrate($name, $data);
        }

        return $name;
    }

    /**
     * Adds the given naming strategy
     *
     * @param NamingStrategyInterface $strategy The naming to register.
     *
     * @return self
     */
    public function setNamingStrategy(NamingStrategyInterface $strategy): NamingStrategyEnabledInterface
    {
        $this->namingStrategy = $strategy;

        return $this;
    }

    /**
     * Gets the naming strategy.
     *
     * @return NamingStrategyInterface|null
     */
    public function getNamingStrategy(): ?NamingStrategyInterface
    {
        return $this->namingStrategy;
    }

    /**
     * Checks if a naming strategy exists.
     *
     * @return bool
     */
    public function hasNamingStrategy(): bool
    {
        return $this->namingStrategy !== null;
    }

    /**
     * Removes the naming strategy
     *
     * @return self
     */
    public function removeNamingStrategy(): NamingStrategyEnabledInterface
    {
        $this->namingStrategy = null;

        return $this;
    }
}
