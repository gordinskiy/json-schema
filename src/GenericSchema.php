<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema;

use Webmozart\Assert\Assert;

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
        if (get_class($this) === self::class) {
            Assert::notEmpty(
                array_filter(func_get_args(), static fn ($value) => $value !== null),
                'At least one generic schema argument must be provided.'
            );
        }
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'default' => $this->default,
            'const' => $this->const,
            'examples' => $this->examples,
            'enum' => $this->enum,
            'readOnly' => $this->readOnly,
            'writeOnly' => $this->writeOnly,
            'deprecated' => $this->deprecated,
            'comment' => $this->comment,
        ], static fn (mixed $value) => $value !== null);
    }
}
