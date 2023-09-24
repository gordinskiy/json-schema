<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Enum;

use Gordinskiy\JsonSchema\SchemaNodeInterface;
use Webmozart\Assert\Assert;

/**
 * Typeless enum
 * @link https://json-schema.org/understanding-json-schema/reference/generic.html#enumerated-values
 */
final readonly class EnumSchema implements SchemaNodeInterface
{
    /** @var array<mixed> */
    private array $values;

    public function __construct(mixed ...$values)
    {
        Assert::notEmpty(
            value: $values,
            message: 'Enum must contain at least one element.'
        );

        $this->values = $values;
    }

    public function jsonSerialize(): array
    {
        return [
            'enum' => $this->values,
        ];
    }
}
