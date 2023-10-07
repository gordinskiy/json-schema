<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Array;

use Gordinskiy\JsonSchema\GenericSchema;
use Gordinskiy\JsonSchema\NodeType;
use Gordinskiy\JsonSchema\SchemaNodeInterface;
use Webmozart\Assert\Assert;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/array
 *
 * @template-extends GenericSchema<mixed[]>
 */
final readonly class ArraySchema extends GenericSchema
{
    /**
     * @inheritDoc
     *
     * @param SchemaNodeInterface[]|null $prefixItems
     */
    public function __construct(
        private SchemaNodeInterface|bool|null $items = null,
        private ?array $prefixItems = null,
        private ?SchemaNodeInterface $contains = null,
        private ?int $minContains = null,
        private ?int $maxContains = null,
        private ?int $minItems = null,
        private ?int $maxItems = null,
        private ?bool $uniqueItems = null,
        ?string $title = null,
        ?string $description = null,
        ?string $comment = null,
        array $default = null,
        array $const = null,
        ?array $examples = null,
        ?array $enum = null,
        ?bool $readOnly = null,
        ?bool $writeOnly = null,
        ?bool $deprecated = null,
    ) {
        if ($minContains !== null) {
            Assert::natural(
                value: $minContains,
                message: 'Array minContains constrain value must be a non-negative number.'
            );
        }

        if ($maxContains !== null) {
            Assert::natural(
                value: $maxContains,
                message: 'Array maxContains constrain value must be a non-negative number.'
            );
        }

        if ($minContains !== null && $maxContains !== null) {
            Assert::greaterThanEq(
                value: $maxContains,
                limit: $minContains,
                message: 'Array minContains constrain cant be greater than maxContains constrain.'
            );
        }


        if ($minItems !== null) {
            Assert::natural(
                value: $minItems,
                message: 'Array minItems constrain value must be a non-negative number.'
            );
        }

        if ($maxItems !== null) {
            Assert::natural(
                value: $maxItems,
                message: 'Array maxItems constrain value must be a non-negative number.'
            );
        }

        if ($minItems !== null && $maxItems !== null) {
            Assert::greaterThanEq(
                value: $maxItems,
                limit: $minItems,
                message: 'Array minItems constrain cant be greater than maxItems constrain.'
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
            'type' => NodeType::Array->value,
            'items' => $this->items,
            'prefixItems' => $this->prefixItems,
            'contains' => $this->contains,
            'minContains' => $this->minContains,
            'maxContains' => $this->maxContains,
            'minItems' => $this->minItems,
            'maxItems' => $this->maxItems,
            'uniqueItems' => $this->uniqueItems,
            ...parent::jsonSerialize(),
        ], static fn (mixed $value) => $value !== null);
    }
}
