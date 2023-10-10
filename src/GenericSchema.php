<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema;

/**
 * @template Type
 */
readonly class GenericSchema implements SchemaNodeInterface
{
    /**
     * @param Type|null $default
     * @param Type|null $const
     * @param Type[]|null $examples
     * @param Type[]|null $enum
     */
    public function __construct(
        private ?string $title = null,
        private ?string $description = null,
        private ?string $comment = null,
        private mixed $default = null,
        private mixed $const = null,
        private ?array $examples = null,
        private ?array $enum = null,
        private ?bool $readOnly = null,
        private ?bool $writeOnly = null,
        private ?bool $deprecated = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'default' => $this->default,
            'const' => $this->const,
            'examples' => is_array($this->examples) ? array_values($this->examples) : null,
            'enum' => is_array($this->enum) ? array_values($this->enum) : null,
            'readOnly' => $this->readOnly,
            'writeOnly' => $this->writeOnly,
            'deprecated' => $this->deprecated,
            'comment' => $this->comment,
        ], static fn (mixed $value) => $value !== null);
    }
}
