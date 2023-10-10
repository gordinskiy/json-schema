<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\String;

use Gordinskiy\JsonSchema\GenericSchema;
use Gordinskiy\JsonSchema\NodeType;
use Webmozart\Assert\Assert;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/string.html
 *
 * @template-extends GenericSchema<string>
 */
final readonly class StringSchema extends GenericSchema
{
    /**
     * @inheritDoc
     */
    public function __construct(
        private ?int $minLength = null,
        private ?int $maxLength = null,
        private ?string $pattern = null,
        private ?StringFormat $format = null,
        ?string $title = null,
        ?string $description = null,
        ?string $comment = null,
        string $default = null,
        string $const = null,
        ?array $examples = null,
        ?array $enum = null,
        ?bool $readOnly = null,
        ?bool $writeOnly = null,
        ?bool $deprecated = null,
    ) {
        if (!empty($examples)) {
            array_walk($examples, static fn ($example) => Assert::string($example));
        }

        if (!empty($enum)) {
            array_walk($enum, static fn ($value) => Assert::string($value));
        }

        parent::__construct(
            title: $title,
            description: $description,
            comment: $comment,
            default: $default,
            const: $const,
            examples: $examples,
            enum: $enum,
            readOnly: $readOnly,
            writeOnly: $writeOnly,
            deprecated: $deprecated,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'type' => NodeType::String->value,
            'minLength' => $this->minLength,
            'maxLength' => $this->maxLength,
            'pattern' => $this->pattern,
            'format' => $this->format,
            ...parent::jsonSerialize(),
        ], static fn (mixed $value) => $value !== null);
    }
}
