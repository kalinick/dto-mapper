<?php

namespace MapperBundle\Hydrator;

use GeneratedHydrator\Configuration;
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
     * @var array
     */
    protected $strategies = [];

    /**
     * @var NamingStrategyInterface|null
     */
    protected $namingStrategy;

    /**
     * {@inheritDoc}
     */
    public function hasStrategy(string $name): bool
    {
        if (\array_key_exists($name, $this->strategies)) {
            return true;
        }

        return \array_key_exists('*', $this->strategies);
    }

    /**
     * {@inheritDoc}
     */
    public function addStrategy(string $name, StrategyInterface $strategy): StrategyEnabledInterface
    {
        $this->strategies[$name] = $strategy;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeStrategy(string $name): StrategyEnabledInterface
    {
        unset($this->strategies[$name]);

        return $this;
    }

    /**
     * {@inheritDoc}
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
     * @param  string $name    The name of the strategy to use.
     * @param  mixed  $value   The value that should be converted.
     * @param  mixed  $context The object is optionally provided as context.
     *
     * @return mixed
     */
    public function extractValue(string $name, $value, $context = null)
    {
        if ($this->hasStrategy($name)) {
            $strategy = $this->getStrategy($name);
            $value = $strategy->extract($value, $context);
        }

        return $value;
    }

    /**
     * Converts a value for hydration. If no strategy exists the plain value is returned.
     *
     * @param string $name    The name of the strategy to use.
     * @param mixed  $value   The value that should be converted.
     * @param mixed  $context The whole data is optionally provided as context.
     * @return mixed
     */
    protected function hydrateValue(string $name, $value, $context = null)
    {
        if ($this->hasStrategy($name)) {
            $strategy = $this->getStrategy($name);
            $value = $strategy->hydrate($value, $context);
        }

        return $value;
    }

    /**
     * Convert a name for extraction. If no naming strategy exists, the plain value is returned.
     *
     * @param string $name    The name to convert.
     * @param mixed  $context The object is optionally provided as context.
     *
     * @return string
     */
    protected function extractName(string $name, $context = null): string
    {
        if ($this->hasNamingStrategy()) {
            $name = $this->getNamingStrategy()->extract($name, $context);
        }

        return $name;
    }

    /**
     * Converts a value for hydration. If no naming strategy exists, the plain value is returned.
     *
     * @param string $name    The name to convert.
     * @param array  $context The whole data is optionally provided as context.
     *
     * @return string
     */
    protected function hydrateName(string $name, $context = null): string
    {
        if ($this->hasNamingStrategy()) {
            $name = $this->getNamingStrategy()->hydrate($name, $context);
        }

        return $name;
    }

    /**
     * {@inheritDoc}
     */
    public function setNamingStrategy(NamingStrategyInterface $strategy): NamingStrategyEnabledInterface
    {
        $this->namingStrategy = $strategy;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamingStrategy(): ?NamingStrategyInterface
    {
        return $this->namingStrategy;
    }

    /**
     * {@inheritDoc}
     */
    public function hasNamingStrategy(): bool
    {
        return $this->namingStrategy !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function removeNamingStrategy(): NamingStrategyEnabledInterface
    {
        $this->namingStrategy = null;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function extract(object $type): array
    {
        $className = \get_class($type);
        $config = new Configuration($className);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $hydrator = new $hydratorClass();
        /* @var HydratorInterface $hydrator */
        $extracted = $hydrator->extract($type);

        foreach ($extracted as $name => $value) {
            $hydratedName = $this->extractName($name);
            $extracted[$hydratedName] = $this->extractValue($hydratedName, $value);
        }

        return $extracted;
    }
}
