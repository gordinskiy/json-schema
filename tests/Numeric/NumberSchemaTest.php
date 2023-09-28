<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Numeric;

use Gordinskiy\JsonSchema\Numeric\NumberSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class NumberSchemaTest extends TestCase
{
    #[
        DataProvider('valid_number_schema_provider'),
        DataProvider('valid_number_generic_schema_provider'),
    ]
    public function test_json_schema_format(NumberSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_number_schema_provider(): \Generator
    {
        yield 'Schema without constraints' => [
            'Object' => new NumberSchema(),
            'Expected result' => '{"type":"number"}',
        ];
        yield 'Schema with multiple of constraints' => [
            'Object' => new NumberSchema(multipleOf: 2.5),
            'Expected result' => '{"type":"number","multipleOf":2.5}',
        ];
        yield 'Schema with minimum constraints' => [
            'Object' => new NumberSchema(minimum: 999.9),
            'Expected result' => '{"type":"number","minimum":999.9}',
        ];
        yield 'Schema with exclusive minimum constraints' => [
            'Object' => new NumberSchema(exclusiveMinimum: 49.9),
            'Expected result' => '{"type":"number","exclusiveMinimum":49.9}',
        ];
        yield 'Schema with exclusive minimum constraints (Draft-4 style)' => [
            'Object' => new NumberSchema(minimum: 49.9, exclusiveMinimum: true),
            'Expected result' => '{"type":"number","minimum":49.9,"exclusiveMinimum":true}',
        ];
        yield 'Schema with maximum constraints' => [
            'Object' => new NumberSchema(maximum: 10.6),
            'Expected result' => '{"type":"number","maximum":10.6}',
        ];
        yield 'Schema with exclusive maximum constraints' => [
            'Object' => new NumberSchema(exclusiveMaximum: 12.1),
            'Expected result' => '{"type":"number","exclusiveMaximum":12.1}',
        ];
        yield 'Schema with exclusive maximum constraints (Draft-4 style)' => [
            'Object' => new NumberSchema(maximum: 12.1, exclusiveMaximum: true),
            'Expected result' => '{"type":"number","maximum":12.1,"exclusiveMaximum":true}',
        ];
    }

    public static function valid_number_generic_schema_provider(): \Generator
    {
        yield 'Schema without constraints. With title' => [
            'Object' => new NumberSchema(title: 'Schema title'),
            'Expected result' => '{"type":"number","title":"Schema title"}',
        ];
        yield 'Schema without constraints. With description' => [
            'Object' => new NumberSchema(description: 'Schema without constraints'),
            'Expected result' => '{"type":"number","description":"Schema without constraints"}',
        ];
        yield 'Schema without constraints. With comment' => [
            'Object' => new NumberSchema(comment: 'Comment test'),
            'Expected result' => '{"type":"number","comment":"Comment test"}',
        ];
        yield 'Schema without constraints. With default value' => [
            'Object' => new NumberSchema(default: 3.14),
            'Expected result' => '{"type":"number","default":3.14}',
        ];
        yield 'Schema without constraints. With const value' => [
            'Object' => new NumberSchema(const: 3.3),
            'Expected result' => '{"type":"number","const":3.3}',
        ];
        yield 'Schema without constraints. With examples' => [
            'Object' => new NumberSchema(examples: [1.1, 2.5, 10.9]),
            'Expected result' => '{"type":"number","examples":[1.1,2.5,10.9]}',
        ];
        yield 'Schema without constraints. Read only' => [
            'Object' => new NumberSchema(readOnly: true),
            'Expected result' => '{"type":"number","readOnly":true}',
        ];
        yield 'Schema without constraints. Write only' => [
            'Object' => new NumberSchema(writeOnly: true),
            'Expected result' => '{"type":"number","writeOnly":true}',
        ];
        yield 'Schema without constraints. Deprecated' => [
            'Object' => new NumberSchema(deprecated: true),
            'Expected result' => '{"type":"number","deprecated":true}',
        ];
        yield 'Schema with enum constraint.' => [
            'Object' => new NumberSchema(enum: [-100.1, 0, 1.25, 2.3, 3.333, 4.25, 5]),
            'Expected result' => '{"type":"number","enum":[-100.1,0,1.25,2.3,3.333,4.25,5]}',
        ];
    }
}
