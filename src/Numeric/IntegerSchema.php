<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Numeric;

use Gordinskiy\JsonSchema\NodeType;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/numeric.html#integer
 */
final readonly class IntegerSchema extends AbstractNumericSchema
{
    public function jsonSerialize(): array
    {
        return [
            'type' => NodeType::Integer->value,
            ...parent::jsonSerialize(),
        ];
    }
}