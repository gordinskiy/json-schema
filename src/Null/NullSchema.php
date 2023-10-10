<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Null;

use Gordinskiy\JsonSchema\NodeType;
use Gordinskiy\JsonSchema\SchemaNodeInterface;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/null
 */
final readonly class NullSchema implements SchemaNodeInterface
{
    public function jsonSerialize(): array
    {
        return [
            'type' => NodeType::Null->value,
        ];
    }
}
