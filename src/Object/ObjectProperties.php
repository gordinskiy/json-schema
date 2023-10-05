<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Object;

use Gordinskiy\JsonSchema\SchemaNodeInterface;
use Webmozart\Assert\Assert;

final readonly class ObjectProperties implements SchemaNodeInterface
{
    /** @var ObjectProperty[] */
    private array $properties;

    public function __construct(ObjectProperty ...$properties)
    {
        Assert::notEmpty(
            value: $properties,
            message: 'At least one property must be provided.'
        );

        $this->properties = $properties;
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            ...array_map(
                static fn(ObjectProperty $property) => $property->jsonSerialize(),
                $this->properties,
            ),
        );
    }
}
