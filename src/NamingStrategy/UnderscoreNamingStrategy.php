<?php

namespace DataMapper\NamingStrategy;

/**
 * Class UnderscoreNamingStrategy
 */
final class UnderscoreNamingStrategy implements NamingStrategyInterface
{
    /**
     * {@inheritdoc}
     */
    public function hydrate(string $name, $context = null): string
    {
        return $this->format($name);
    }

    /**
     * {@inheritdoc}
     */
    public function extract(string $name): string
    {
        return $this->format($name);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function format(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}
