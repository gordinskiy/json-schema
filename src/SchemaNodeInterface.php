<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema;

interface SchemaNodeInterface extends \JsonSerializable
{
    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array;
}
