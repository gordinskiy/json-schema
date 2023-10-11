<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Numeric;

use Gordinskiy\JsonSchema\GenericSchema;
use Webmozart\Assert\Assert;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/numeric.html
 *
 * @template-extends GenericSchema<integer|float>
 */
abstract readonly class AbstractNumericSchema extends GenericSchema
{
    /**
     * @inheritDoc
     */
    public function __construct(
        private int|float|null $multipleOf = null,
        private int|float|null $minimum = null,
        private int|float|null $exclusiveMinimum = null,
        private int|float|null $maximum = null,
        private int|float|null $exclusiveMaximum = null,
        ?string $title = null,
        ?string $description = null,
        ?string $comment = null,
        int|float|null $default = null,
        int|float|null $const = null,
        ?array $examples = null,
        ?array $enum = null,
        ?bool $readOnly = null,
        ?bool $writeOnly = null,
        ?bool $deprecated = null,
    ) {
        if (!empty($examples)) {
            array_walk($examples, static fn ($example) => Assert::numeric($example));
        }

        if (!empty($enum)) {
            array_walk($enum, static fn ($value) => Assert::numeric($value));
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
            'multipleOf' => $this->multipleOf,
            'minimum' => $this->minimum,
            'exclusiveMinimum' => $this->exclusiveMinimum,
            'maximum' => $this->maximum,
            'exclusiveMaximum' => $this->exclusiveMaximum,
            ...parent::jsonSerialize(),
        ];
    }
}
