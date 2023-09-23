<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\String;

use Gordinskiy\JsonSchema\NodeType;
use Gordinskiy\JsonSchema\SchemaNodeInterface;
use Webmozart\Assert\Assert;

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
        if ($minLength !== null) {
            Assert::natural(
                value: $minLength,
                message: 'String min length constrain value must be a non-negative number.'
            );
        }

        if ($maxLength !== null) {
            Assert::natural(
                value: $maxLength,
                message: 'String max length constrain value must be a non-negative number.'
            );
        }

        if ($minLength !== null && $maxLength !== null) {
            Assert::greaterThanEq(
                value: $maxLength,
                limit: $minLength,
                message: 'String min length constrain cant be greater than max length constrain.'
            );
        }
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
