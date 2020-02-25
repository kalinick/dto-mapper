<?php

namespace DataMapper\Hydrator;

use DataMapper\MappingRegistry\Exception\UnknownStrategyFieldException;
use DataMapper\NamingStrategy\NamingStrategyEnabledInterface;
use DataMapper\NamingStrategy\NamingStrategyInterface;
use DataMapper\Strategy\StrategyEnabledInterface;
use DataMapper\Strategy\StrategyInterface;
use DataMapper\Exception\InvalidArgumentException;

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
     * @var HydratedClassesFactory
     */
    protected $classesFactory;

    /**
     * AbstractHydrator constructor.
     *
     * @param HydratedClassesFactory $classesFactory
     */
    public function __construct(HydratedClassesFactory $classesFactory)
    {
        $this->classesFactory = $classesFactory;
    }

    /**
     * Reset settings
     */
    public function __clone()
    {
        $this->strategies = [];
        $this->namingStrategy = null;
    }

    /**
     * {@inheritDoc}
     */
    public function hasStrategy(string $name): bool
    {
        if (\array_key_exists($name, $this->strategies)) {
            return true;
        }

        if ($this->hasNamingStrategy()
            && \array_key_exists($this->getNamingStrategy()->hydrate($name), $this->strategies)
        ) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function addStrategy(string $name, StrategyInterface $strategy): void
    {
        $this->strategies[$name] = $strategy;
    }

    /**
     * {@inheritDoc}
     */
    public function removeStrategy(string $name): void
    {
        unset($this->strategies[$name]);
    }

    /**
     * {@inheritDoc}
     */
    public function getStrategy(string $name): StrategyInterface
    {
        if ($this->hasStrategy($name)) {
            return $this->strategies[$name];
        }

        if ($this->hasNamingStrategy()
            && \array_key_exists($this->getNamingStrategy()->hydrate($name), $this->strategies)
        ) {
            return $$this->strategies[$this->getNamingStrategy()->hydrate($name)];
        }


        throw new UnknownStrategyFieldException($name);
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
            $value = $strategy->hydrate($value, [$context, $name]);
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
    public function setNamingStrategy(NamingStrategyInterface $strategy): void
    {
        $this->namingStrategy = $strategy;
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
    public function removeNamingStrategy(): void
    {
        $this->namingStrategy = null;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @param mixed $source
     * @param mixed $destination
     *
     * @return void
     */
    abstract protected function validateTypes($source, $destination): void;

    /**
     * @param array  $source
     * @param object $target
     *
     * @return object
     */
    protected function hydrateToObject(array $source, $target)
    {
        $className = \get_class($target);
        $hydrator = $this->classesFactory->createHydratorClass($className);

        return $hydrator->hydrate($source, $target);
    }

    /**
     * {@inheritDoc}
     */
    public function extract($type): array
    {
        $className = \get_class($type);
        $hydrator = $this->classesFactory->createHydratorClass($className);
        $extracted = $hydrator->extract($type);

        foreach ($extracted as $name => $value) {
            $hydratedName = $this->extractName($name);
            if ($name !== $hydratedName) {
                unset($extracted[$name]);
            }
            $extracted[$hydratedName] = $value;
        }

        return $extracted;
    }
}
