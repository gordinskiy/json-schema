<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Object;

use Gordinskiy\JsonSchema\GenericSchema;
use Gordinskiy\JsonSchema\NodeType;
use Gordinskiy\JsonSchema\SchemaNodeInterface;
use Gordinskiy\JsonSchema\String\StringSchema;
use Webmozart\Assert\Assert;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/object.html
 *
 * @template-extends GenericSchema<object>
 */
final readonly class ObjectSchema extends GenericSchema
{
    /**
     * @inheritDoc
     * @param string[] $required
     */
    public function __construct(
        private ?ObjectProperties $properties = null,
        private ?ObjectProperties $patternProperties = null,
        private ?StringSchema $propertyNames = null,
        private ?int $minProperties = null,
        private ?int $maxProperties = null,
        private ?array $required = null,
        private bool|SchemaNodeInterface|null $additionalProperties = null,
        private ?bool $unevaluatedProperties = null,
        ?string $title = null,
        ?string $description = null,
        ?string $comment = null,
        object $default = null,
        object $const = null,
        ?array $examples = null,
        ?array $enum = null,
        ?bool $readOnly = null,
        ?bool $writeOnly = null,
        ?bool $deprecated = null,
    ) {
        if ($minProperties !== null) {
            Assert::natural(
                value: $minProperties,
                message: 'Object minProperties constrain value must be a non-negative number.'
            );
        }

        if ($maxProperties !== null) {
            Assert::natural(
                value: $maxProperties,
                message: 'Object maxProperties constrain value must be a non-negative number.'
            );
        }

        if ($minProperties !== null && $maxProperties !== null) {
            Assert::greaterThanEq(
                value: $maxProperties,
                limit: $minProperties,
                message: 'Object minProperties constrain cant be greater than maxProperties constrain.'
            );
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
            'type' => NodeType::Object->value,
            'properties' => $this->properties?->jsonSerialize(),
            'patternProperties' => $this->patternProperties?->jsonSerialize(),
            'propertyNames' => $this->propertyNames,
            'minProperties' => $this->minProperties,
            'maxProperties' => $this->maxProperties,
            'required' => $this->required,
            'additionalProperties' => $this->additionalProperties,
            'unevaluatedProperties' => $this->unevaluatedProperties,

            ...parent::jsonSerialize(),
        ], static fn (mixed $value) => $value !== null);
    }
}
