<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Numeric;

use Gordinskiy\JsonSchema\Numeric\IntegerSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Webmozart\Assert\InvalidArgumentException;

final class IntegerSchemaTest extends TestCase
{
    #[
        DataProvider('valid_integer_schema_provider'),
        DataProvider('valid_integer_generic_schema_provider'),
    ]
    public function test_json_schema_format(IntegerSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_integer_schema_provider(): \Generator
    {
        yield 'Schema without constraints' => [
            'Object' => new IntegerSchema(),
            'Expected result' => '{"type":"integer"}',
        ];
        yield 'Schema with multiple of constraints' => [
            'Object' => new IntegerSchema(multipleOf: 2),
            'Expected result' => '{"type":"integer","multipleOf":2}',
        ];
        yield 'Schema with minimum constraints' => [
            'Object' => new IntegerSchema(minimum: 999),
            'Expected result' => '{"type":"integer","minimum":999}',
        ];
        yield 'Schema with exclusive minimum constraints' => [
            'Object' => new IntegerSchema(exclusiveMinimum: 50),
            'Expected result' => '{"type":"integer","exclusiveMinimum":50}',
        ];
        yield 'Schema with maximum constraints' => [
            'Object' => new IntegerSchema(maximum: 10),
            'Expected result' => '{"type":"integer","maximum":10}',
        ];
        yield 'Schema with exclusive maximum constraints' => [
            'Object' => new IntegerSchema(exclusiveMaximum: 12),
            'Expected result' => '{"type":"integer","exclusiveMaximum":12}',
        ];
    }

    public static function valid_integer_generic_schema_provider(): \Generator
    {
        yield 'Schema without constraints. With title' => [
            'Object' => new IntegerSchema(title: 'Schema title'),
            'Expected result' => '{"type":"integer","title":"Schema title"}',
        ];
        yield 'Schema without constraints. With description' => [
            'Object' => new IntegerSchema(description: 'Schema without constraints'),
            'Expected result' => '{"type":"integer","description":"Schema without constraints"}',
        ];
        yield 'Schema without constraints. With comment' => [
            'Object' => new IntegerSchema(comment: 'Comment test'),
            'Expected result' => '{"type":"integer","comment":"Comment test"}',
        ];
        yield 'Schema without constraints. With default value' => [
            'Object' => new IntegerSchema(default: 5),
            'Expected result' => '{"type":"integer","default":5}',
        ];
        yield 'Schema without constraints. With const value' => [
            'Object' => new IntegerSchema(const: 1),
            'Expected result' => '{"type":"integer","const":1}',
        ];
        yield 'Schema without constraints. With examples' => [
            'Object' => new IntegerSchema(examples: [1, 2, 3]),
            'Expected result' => '{"type":"integer","examples":[1,2,3]}',
        ];
        yield 'Schema without constraints. Read only' => [
            'Object' => new IntegerSchema(readOnly: true),
            'Expected result' => '{"type":"integer","readOnly":true}',
        ];
        yield 'Schema without constraints. Write only' => [
            'Object' => new IntegerSchema(writeOnly: true),
            'Expected result' => '{"type":"integer","writeOnly":true}',
        ];
        yield 'Schema without constraints. Deprecated' => [
            'Object' => new IntegerSchema(deprecated: true),
            'Expected result' => '{"type":"integer","deprecated":true}',
        ];
        yield 'Schema with enum constraint.' => [
            'Object' => new IntegerSchema(enum: [-100, 0, 1, 2, 3, 4, 5]),
            'Expected result' => '{"type":"integer","enum":[-100,0,1,2,3,4,5]}',
        ];
    }

    public function test_example_of_wrong_type(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a numeric. Got: string');

        new IntegerSchema(examples: [4, 'Invalid value']);
    }

    public function test_enum_of_wrong_type(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a numeric. Got: string');

        new IntegerSchema(enum: [9, 'Invalid value']);
    }
}
