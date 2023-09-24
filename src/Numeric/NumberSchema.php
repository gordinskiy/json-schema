<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Numeric;

use Gordinskiy\JsonSchema\NodeType;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/numeric.html#number
 */
final readonly class NumberSchema extends AbstractNumericSchema
{
    public function jsonSerialize(): array
    {
        return array_filter([
            'type' => NodeType::Number->value,
            ...parent::jsonSerialize(),
        ], static fn (mixed $value) => $value !== null);
    }
}
