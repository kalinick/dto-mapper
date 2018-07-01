<?php

namespace DataMapper;

use DataMapper\Hydrator\{
    CollectionHydrator,
    ArraySerializableHydrator,
    ObjectHydrator
};

/**
 * Class TypeResolver
 */
class TypeResolver
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
        $type = self::resolveBaseType($variable);

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
        return self::concatTypes(
            self::resolveStrategyType($source),
            self::resolveStrategyType($destination),
            TypeDict::STRATEGY_GLUE
        );
    }

    /**
     * @param mixed $source
     * @param mixed $destination
     *
     * @return string
     */
    public static function getHydratedType($source, $destination): string
    {
        return self::concatTypes(
            self::resolveBaseType($source),
            self::resolveBaseType($destination),
            TypeDict::HYDRATOR_GLUE
        );
    }

    /**
     * @param mixed $variable
     *
     * @return string
     */
    public static function resolveBaseType($variable): string
    {
        $variableType = \gettype($variable);

        if ($variableType === TypeDict::STRING_TYPE && \class_exists($variable)) {
            $variableType = TypeDict::CLASS_TYPE;
        }

        return $variableType;
    }

    /**
     * @param string $sourceType
     * @param string $destinationType
     * @param string $glue
     *
     * @return string
     */
    public static function concatTypes(string $sourceType, string $destinationType, string $glue): string
    {
        return $sourceType . $glue . $destinationType;
    }
}
