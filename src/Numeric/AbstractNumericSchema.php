<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Numeric;

use Gordinskiy\JsonSchema\SchemaNodeInterface;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/numeric.html
 */
abstract readonly class AbstractNumericSchema implements SchemaNodeInterface
{
    public function __construct(
        private int|float|null $multipleOf = null,
        private int|float|null $minimum = null,
        private int|float|null $exclusiveMinimum = null,
        private int|float|null $maximum = null,
        private int|float|null $exclusiveMaximum = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'multipleOf' => $this->multipleOf,
            'minimum' => $this->minimum,
            'exclusiveMinimum' => $this->exclusiveMinimum,
            'maximum' => $this->maximum,
            'exclusiveMaximum' => $this->exclusiveMaximum,
        ];
    }
}
