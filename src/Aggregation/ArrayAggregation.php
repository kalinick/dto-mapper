<?php

namespace DataMapper\Aggregation;

/**
 * Class ArrayAggregation
 */
class ArrayAggregation
{
    /**
     * @var \Closure[]
     */
    private $keys;

    /**
     * @var \Closure[]
     */
    private $values;

    /**
     * @param array    $keys
     * @param \Closure $extractor
     */
    public function registerKeys(array $keys, \Closure $extractor): void
    {
        $this->keys = [$keys, $extractor];
    }

    /**
     * @param array    $keys
     * @param \Closure $extractor
     */
    public function registerValues(array $keys, \Closure $extractor): void
    {
        $this->values = [$keys, $extractor];
    }

    /**
     * @param array    $raw
     * @param \Closure $reduce
     *
     * @return array
     */
    public function aggregate(array $raw, \Closure $reduce): array
    {
        $result = [];

        foreach ($this->map($raw) as $keys => $values) {
            $key = \implode("\x00", $keys);

            if (!isset($result[$key])) {
                $result[$key] = [
                    'keys' => $keys,
                    'values' => $values,
                ];
                continue;
            }

            foreach ($values as $valueName => $value) {
                $result[$key]['values'][$valueName] = $reduce($result[$key]['values'][$valueName], $value);
            }
        }

        return $result;
    }

    /**
     * @param array $raw
     *
     * @return iterable
     */
    private function map(array $raw): iterable
    {
        [$keys, $keyExtractor] = $this->keys;
        [$valuesKeys, $valueExtractor] = $this->values;

        foreach ($raw as $row) {
            yield \array_combine($keys, $keyExtractor($row)) => \array_combine($valuesKeys, $valueExtractor($row));
        }
    }
}
