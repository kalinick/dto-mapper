<?php

namespace DataMapper\Hydrator;

use DataMapper\TypeDict;
use DataMapper\Hydrator\{
    Exception\UnknownStrategyTypeException,
    NamingStrategy\NamingStrategyEnabledInterface,
    NamingStrategy\NamingStrategyInterface,
    Strategy\StrategyEnabledInterface,
    Strategy\StrategyInterface
};

use GeneratedHydrator\Configuration;

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
        if (array_key_exists($name, $this->strategies)) {
            return true;
        }

        if ($this->hasNamingStrategy() &&
            \array_key_exists($this->getNamingStrategy()->hydrate($name), $this->strategies)
        ) {
            return true;
        }

        return \array_key_exists('*', $this->strategies);
    }

    /**
     * @return bool
     */
    private function hasDefaultStrategy(): bool
    {
        return \array_key_exists(TypeDict::ALL_TYPE, $this->strategies);
    }

    /**
     * @throws UnknownStrategyTypeException
     *
     * @return StrategyInterface
     */
    private function getDefaultStrategy(): StrategyInterface
    {
        if (!$this->hasDefaultStrategy()) {
            throw new UnknownStrategyTypeException(TypeDict::ALL_TYPE);
        }

        return $this->strategies[TypeDict::ALL_TYPE];
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
        if (!isset($this->strategies[$name])) {
            return $this->getDefaultStrategy();
        }

        return $this->strategies[$name];
    }

    /**
     * Converts a value for hydration. If no strategy exists the plain value is returned.
     *
     * @param string $name    The name of the strategy to use.
     * @param mixed  $value   The value that should be converted.
     * @param mixed  $context The whole data is optionally provided as context.
     *
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
     *
     * @return string
     */
    protected function extractName(string $name): string
    {
        if ($this->hasNamingStrategy()) {
            $name = $this->getNamingStrategy()->extract($name);
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
     * @param array  $source
     * @param object $target
     *
     * @return object
     */
    protected function hydrateToObject(array $source, object $target): object
    {
        $className = \get_class($target);
        $config = new Configuration($className);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        /* @var HydratorInterface $hydrator */
        $hydrator = new $hydratorClass();

        return $hydrator->hydrate($source, $target);
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
            unset($extracted[$name]);
            $extracted[$hydratedName] = $value;
        }

        return $extracted;
    }
}
