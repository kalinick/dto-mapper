<?php

namespace DataMapper\Type;

use DataMapper\Hydrator\CollectionHydrator;
use DataMapper\Hydrator\ArraySerializableHydrator;
use DataMapper\Hydrator\ObjectHydrator;

/**
 * Class TypeResolver
 */
final class TypeResolver
{
    /**
     * @return array
     */
    public static function hydrationSupportedTypeSequence(): array
    {
        return [
            TypeDict::ARRAY_TO_OBJECT   => CollectionHydrator::class,
            TypeDict::ARRAY_TO_CLASS    => CollectionHydrator::class,
            TypeDict::OBJECT_TO_ARRAY   => CollectionHydrator::class,
            TypeDict::ARRAY_TO_ARRAY    => ArraySerializableHydrator::class,
            TypeDict::OBJECT_TO_CLASS   => ObjectHydrator::class,
            TypeDict::OBJECT_TO_OBJECT  => ObjectHydrator::class,
        ];
    }

    /**
     * @param $variable
     *
     * @return string
     */
    public static function resolveStrategyType($variable): string
    {
        if (\is_object($variable)) {
            return \get_class($variable);
        }

        $type = self::resolveBaseType($variable);

        // If we $variable is exists class name return name
        return $type === TypeDict::CLASS_TYPE ? $variable : $type;
    }

    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return string
     */
    public static function getStrategyType($source, $destination): string
    {
        return self::resolveStrategyType($source) . TypeDict::STRATEGY_GLUE . self::resolveStrategyType($destination);
    }

    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return string
     */
    public static function getHydratedType($source, $destination): string
    {
        return self::resolveBaseType($source) . TypeDict::HYDRATOR_GLUE . self::resolveBaseType($destination);
    }

    /**
     * @param mixed $variable
     *
     * @return string
     */
    public static function resolveBaseType($variable): string
    {
        $variableType = \gettype($variable);

        if ($variableType !== TypeDict::STRING_TYPE) {
            return $variableType;
        }

        // Hook for array source type support
        if ($variable === TypeDict::ARRAY_TYPE) {
            return TypeDict::ARRAY_TYPE;
        }

        // If type is string check is it class name
        if (\class_exists($variable)) {
            return TypeDict::CLASS_TYPE;
        }

        return $variableType;
    }
}
