<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Boolean;

use Gordinskiy\JsonSchema\NodeType;
use Gordinskiy\JsonSchema\SchemaNodeInterface;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/boolean.html
 */
final readonly class BooleanSchema implements SchemaNodeInterface
{
    public function jsonSerialize(): array
    {
        return [
            'type' => NodeType::Boolean->value,
        ];
    }
}
