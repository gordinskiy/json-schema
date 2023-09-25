<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\Composition;

use Gordinskiy\JsonSchema\SchemaNodeInterface;

abstract readonly class AbstractCompositionSchema implements SchemaNodeInterface
{
    /** @var SchemaNodeInterface[] */
    private array $schemas;

    public function __construct(SchemaNodeInterface ...$schemas)
    {
        $this->schemas = $schemas;
    }

    public function jsonSerialize(): array
    {
        return $this->schemas;
    }
}
