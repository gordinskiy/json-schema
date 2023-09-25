<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Composition;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/combining.html#allof
 */
final readonly class AllOfSchema extends AbstractCompositionSchema
{
    public function jsonSerialize(): array
    {
        return [
            'allOf' => parent::jsonSerialize(),
        ];
    }
}
