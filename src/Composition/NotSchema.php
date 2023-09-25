<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Composition;

use Gordinskiy\JsonSchema\SchemaNodeInterface;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/combining.html#not
 */
final readonly class NotSchema implements SchemaNodeInterface
{
    public function __construct(
        private SchemaNodeInterface $schema
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'not' => $this->schema->jsonSerialize(),
        ];
    }
}
