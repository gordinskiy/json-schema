<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\String;

use Gordinskiy\JsonSchema\NodeType;
use Gordinskiy\JsonSchema\SchemaNodeInterface;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/string.html
 */
final readonly class StringSchema implements SchemaNodeInterface
{
    public function __construct(
        private ?int $minLength = null,
        private ?int $maxLength = null,
        private ?string $pattern = null,
        private ?StringFormat $format = null,
    ) {

    }

    public function jsonSerialize(): array
    {
        return [
            'type' => NodeType::String->value,
            'minLength' => $this->minLength,
            'maxLength' => $this->maxLength,
            'pattern' => $this->pattern,
            'format' => $this->format,
        ];
    }
}
