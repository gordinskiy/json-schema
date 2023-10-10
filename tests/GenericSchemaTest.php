<?php

declare(strict_types=1);

namespace Gordinskiy\Tests;

use Gordinskiy\JsonSchema\GenericSchema;
use PHPUnit\Framework\Attributes\DataProvider;
use Webmozart\Assert\InvalidArgumentException;

final class GenericSchemaTest extends TestCase
{
    #[
        DataProvider('valid_enum_without_constraints')
    ]
    public function test_valid_boolean(mixed $value, GenericSchema $schema): void
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
            'schema' => new GenericSchema(enum: [0, 2, 4, 6, 8]),
        ];
        yield 'Enum schema without constrains. One of floats' => [
            'value' => 3.14,
            'schema' => new GenericSchema(enum: [3.5, 9.9, 3.14]),
        ];
        yield 'Enum schema without constrains. One of strings' => [
            'value' => 'Thursday',
            'schema' => new GenericSchema(enum: ['Monday', 'Sunday', 'Thursday', 'Wednesday']),
        ];
        yield 'Enum schema without constrains. One of arrays' => [
            'value' => [8,9],
            'schema' => new GenericSchema(enum: [[1,2,3], [8,9], [2,4,8]]),
        ];
        yield 'Enum schema without constrains. One of mixed' => [
            'value' => 3.14,
            'schema' => new GenericSchema(enum: [2, [8,9], [2,4,8], 3.14, 'Sunday']),
        ];
        yield 'Enum schema without constrains. Null value' => [
            'value' => null,
            'schema' => new GenericSchema(enum: [2, [8,9], [2,4,8], 3.14, null]),
        ];
    }

    #[
        DataProvider('invalid_enum_without_constraints'),
    ]
    public function test_invalid_boolean(mixed $value, GenericSchema $schema): void
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
            'schema' => new GenericSchema(enum: [0, 2, 4, 6, 8]),
        ];
        yield 'Enum schema without constrains. Float not one of integers' => [
            'value' => 2.0,
            'schema' => new GenericSchema(enum: [0, 2, 4, 6, 8]),
        ];
        yield 'Enum schema without constrains. Not one of floats' => [
            'value' => 2.19,
            'schema' => new GenericSchema(enum: [3.5, 9.9, 3.14]),
        ];
        yield 'Enum schema without constrains. Not one of strings' => [
            'value' => 'March',
            'schema' => new GenericSchema(enum: ['Monday', 'Sunday', 'Thursday', 'Wednesday']),
        ];
        yield 'Enum schema without constrains. Not one of arrays' => [
            'value' => [2,3],
            'schema' => new GenericSchema(enum: [[1,2,3], [8,9], [2,4,8]]),
        ];
        yield 'Enum schema without constrains. Not one of mixed' => [
            'value' => 3,
            'schema' => new GenericSchema(enum: [2, [8,9], [2,4,8], 3.14, 'Sunday']),
        ];
        yield 'Enum schema without constrains. Null not one values' => [
            'value' => null,
            'schema' => new GenericSchema(enum: [2, [8,9], [2,4,8], 3.14]),
        ];
    }

    #[DataProvider('valid_enum_schema_provider')]
    public function test_json_schema_format(GenericSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_enum_schema_provider(): \Generator
    {
        yield 'Schema with list of integers' => [
            'Object' => new GenericSchema(enum: [100, 12, 35]),
            'Expected result' => '{"enum":[100,12,35]}',
        ];
        yield 'Schema with list of floats' => [
            'Object' => new GenericSchema(enum: [3.145, 9.999, 3.333]),
            'Expected result' => '{"enum":[3.145,9.999,3.333]}',
        ];
        yield 'Schema with list of string' => [
            'Object' => new GenericSchema(enum: ['March', 'May', 'April']),
            'Expected result' => '{"enum":["March","May","April"]}',
        ];

        yield 'Schema with title' => [
            'Object' => new GenericSchema(title: 'Schema title'),
            'Expected result' => '{"title":"Schema title"}',
        ];
        yield 'Schema with description' => [
            'Object' => new GenericSchema(description: 'Schema without constraints'),
            'Expected result' => '{"description":"Schema without constraints"}',
        ];
        yield 'Schema with comment' => [
            'Object' => new GenericSchema(comment: 'Comment test'),
            'Expected result' => '{"comment":"Comment test"}',
        ];
        yield 'Schema with default value' => [
            'Object' => new GenericSchema(default: 3.14),
            'Expected result' => '{"default":3.14}',
        ];
        yield 'Schema with const value' => [
            'Object' => new GenericSchema(const: 3.3),
            'Expected result' => '{"const":3.3}',
        ];
        yield 'Schema with examples' => [
            'Object' => new GenericSchema(examples: [1.1, 2.5, 10.9]),
            'Expected result' => '{"examples":[1.1,2.5,10.9]}',
        ];
        yield 'Schema with read only flag' => [
            'Object' => new GenericSchema(readOnly: true),
            'Expected result' => '{"readOnly":true}',
        ];
        yield 'Schema with write only flag' => [
            'Object' => new GenericSchema(writeOnly: true),
            'Expected result' => '{"writeOnly":true}',
        ];
        yield 'Schema with deprecated flag' => [
            'Object' => new GenericSchema(deprecated: true),
            'Expected result' => '{"deprecated":true}',
        ];
    }
}
