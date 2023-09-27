<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Numeric;

use Gordinskiy\JsonSchema\Numeric\NumberSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class NumberSchemaTest extends TestCase
{
    #[DataProvider('valid_number_schema_provider')]
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
}
