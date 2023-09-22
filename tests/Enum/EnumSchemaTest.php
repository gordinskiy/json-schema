<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Enum;

use Gordinskiy\JsonSchema\Enum\EnumSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class EnumSchemaTest extends TestCase
{
    #[
        DataProvider('valid_enum_without_constraints')
    ]
    public function test_valid_boolean(mixed $value, EnumSchema $schema): void
    {
        self::assertEmpty(
            $this->validate(
                $value,
                json_encode($schema)
            )
        );
    }

    public static function valid_enum_without_constraints(): \Generator
    {
        yield 'Enum schema without constrains. One of integers' => [
            'value' => 6,
            'schema' => new EnumSchema(0, 2, 4, 6, 8),
        ];
        yield 'Enum schema without constrains. One of floats' => [
            'value' => 3.14,
            'schema' => new EnumSchema(3.5, 9,9, 3.14),
        ];
        yield 'Enum schema without constrains. One of strings' => [
            'value' => 'Thursday',
            'schema' => new EnumSchema('Monday', 'Sunday', 'Thursday', 'Wednesday'),
        ];
        yield 'Enum schema without constrains. One of arrays' => [
            'value' => [8,9],
            'schema' => new EnumSchema([1,2,3], [8,9], [2,4,8]),
        ];
        yield 'Enum schema without constrains. One of mixed' => [
            'value' => 3.14,
            'schema' => new EnumSchema(2, [8,9], [2,4,8], 3.14, 'Sunday'),
        ];
        yield 'Enum schema without constrains. Null value' => [
            'value' => null,
            'schema' => new EnumSchema(2, [8,9], [2,4,8], 3.14, null),
        ];
    }

    #[
        DataProvider('invalid_enum_without_constraints'),
    ]
    public function test_invalid_boolean(mixed $value, EnumSchema $schema): void
    {
        self::assertNotEmpty(
            $this->validate(
                $value,
                json_encode($schema)
            )
        );
    }

    public static function invalid_enum_without_constraints(): \Generator
    {
        yield 'Enum schema without constrains. Not one of integers' => [
            'value' => 1,
            'schema' => new EnumSchema(0, 2, 4, 6, 8),
        ];
        yield 'Enum schema without constrains. Float not one of integers' => [
            'value' => 2.0,
            'schema' => new EnumSchema(0, 2, 4, 6, 8),
        ];
        yield 'Enum schema without constrains. Not one of floats' => [
            'value' => 2.19,
            'schema' => new EnumSchema(3.5, 9,9, 3.14),
        ];
        yield 'Enum schema without constrains. Not one of strings' => [
            'value' => 'March',
            'schema' => new EnumSchema('Monday', 'Sunday', 'Thursday', 'Wednesday'),
        ];
        yield 'Enum schema without constrains. Not one of arrays' => [
            'value' => [2,3],
            'schema' => new EnumSchema([1,2,3], [8,9], [2,4,8]),
        ];
        yield 'Enum schema without constrains. Not one of mixed' => [
            'value' => 3,
            'schema' => new EnumSchema(2, [8,9], [2,4,8], 3.14, 'Sunday'),
        ];
        yield 'Enum schema without constrains. Null not one values' => [
            'value' => null,
            'schema' => new EnumSchema(2, [8,9], [2,4,8], 3.14),
        ];
    }
}
