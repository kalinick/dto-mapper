<?php

namespace DataMapper\Hydrator;

use DataMapper\Exception\InvalidArgumentException;
use DataMapper\Mapper\Registry\StrategyRegistryInterface;
use DataMapper\TypeResolver;

/**
 * Class ObjectHydrator
 */
final class ObjectHydrator extends AbstractHydrator
{
    /**
     * @var StrategyRegistryInterface
     */
    private $strategyRegistry;

    /**
     * ObjectHydrator constructor.
     *
     * @param StrategyRegistryInterface $strategyRegistry
     */
    public function __construct(StrategyRegistryInterface $strategyRegistry)
    {
        $this->strategyRegistry = $strategyRegistry;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($source, $destination)
    {
        $notValid = !\is_object($source) || (!\is_object($destination) || \class_exists($destination));

        if ($notValid) {
            $message = '$source argument - must be object type,' .
                '$destination argument - must by exist class name or object type';

            throw new InvalidArgumentException($message);
        }

        $dto = \is_object($destination) ? $destination : new $destination();
        $destinationClass = \get_class($dto);
        $sourceClass = \get_class($source);
        $strategyTypeKey = TypeResolver::getStrategyType($sourceClass, $destinationClass);

        $mappedDestinationProps = $this->strategyRegistry->getMapperPropertiesKeys($strategyTypeKey);
        $destinationContent = $this->filterSourceProps($destination, $mappedDestinationProps);

        foreach ($mappedDestinationProps as $destinationProp) {
            $destinationContent[$destinationProp] = $this->hydrateValue($destinationProp, $source, $destinationClass);
        }

        return $this->hydrateToObject($source, $dto);
    }

    /**
     * @param object $source
     * @param array  $mappedDestinationProps
     *
     * @return array
     */
    private function filterSourceProps(object $source, array $mappedDestinationProps): array
    {
        $destinationContent = $this->extract($source);
        $excludeKeys = \array_keys($destinationContent, $mappedDestinationProps);

        return \array_filter(
            $destinationContent,
            function ($key) use ($excludeKeys) {
                return !\in_array($key, $excludeKeys, false);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
