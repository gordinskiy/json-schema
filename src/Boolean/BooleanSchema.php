<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Boolean;

use Gordinskiy\JsonSchema\GenericSchema;
use Gordinskiy\JsonSchema\NodeType;
use Webmozart\Assert\Assert;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/boolean.html
 *
 * @template-extends GenericSchema<bool>
 */
final readonly class BooleanSchema extends GenericSchema
{
    /**
     * @inheritDoc
     */
    public function __construct(
        ?string $title = null,
        ?string $description = null,
        ?string $comment = null,
        bool $default = null,
        bool $const = null,
        ?array $examples = null,
        ?array $enum = null,
        ?bool $readOnly = null,
        ?bool $writeOnly = null,
        ?bool $deprecated = null,
    ) {
        if (!empty($examples)) {
            array_walk($examples, static fn ($example) => Assert::boolean($example));
        }

        if (!empty($enum)) {
            array_walk($enum, static fn ($value) => Assert::boolean($value));
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
        return [
            'type' => NodeType::Boolean->value,
            ...parent::jsonSerialize(),
        ];
    }
}
