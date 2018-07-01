<?php

namespace DataMapper\Mapper;

use DataMapper\Mapper\Registry;

/**
 * Class MappingRegistry
 */
class MappingRegistry implements
    Registry\NamingStrategyRegistryInterface,
    Registry\CollectionRelationsRegistryInterface,
    Registry\StrategyRegistryInterface
{
    public const ALL_STRATEGY = '*';

    use Registry\NamingStrategyRegistryTrait,
        Registry\DestinationRegistryTrait,
        Registry\RelationsRegistryTrait,
        Registry\StrategyRegistryTrait;
}
