<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Composition;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/combining.html#anyof
 */
final readonly class AnyOfSchema extends AbstractCompositionSchema
{
    public function jsonSerialize(): array
    {
        return [
            'anyOf' => parent::jsonSerialize(),
        ];
    }
}
