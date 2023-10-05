<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Object;

use Gordinskiy\JsonSchema\SchemaNodeInterface;

final readonly class ObjectProperty implements SchemaNodeInterface
{
    public function __construct(
        private string $name,
        private SchemaNodeInterface $value,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            $this->name => $this->value,
        ];
    }
}
