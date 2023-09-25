<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Composition;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/combining.html#allof
 */
final readonly class OneOfSchema extends AbstractCompositionSchema
{
    public function jsonSerialize(): array
    {
        return [
            'oneOf' => parent::jsonSerialize(),
        ];
    }
}
