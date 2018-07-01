<?php

namespace DataMapper\Hydrator\NamingStrategy;

/**
 * Class SnakeCaseNamingStrategy
 */
final class SnakeCaseNamingStrategy implements NamingStrategyInterface
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
        $string = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        $string[0] = strtolower($string[0]);

        return $string;
    }
}
