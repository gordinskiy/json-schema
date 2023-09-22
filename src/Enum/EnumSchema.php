<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Enum;

use Gordinskiy\JsonSchema\SchemaNodeInterface;

/**
 * Typeless enum
 * @link https://json-schema.org/understanding-json-schema/reference/generic.html#enumerated-values
 */
final readonly class EnumSchema implements SchemaNodeInterface
{
    private array $values;
    public function __construct(mixed ...$values)
    {
        $this->values = $values;
    }

    public function jsonSerialize(): array
    {
        return [
            'enum' => $this->values,
        ];
    }
}
