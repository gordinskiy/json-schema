<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Numeric;

use Gordinskiy\JsonSchema\Numeric\IntegerSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class IntegerSchemaTest extends TestCase
{
    #[DataProvider('valid_integer_schema_provider')]
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
        yield 'Schema with exclusive minimum constraints (Draft-4 style)' => [
            'Object' => new IntegerSchema(minimum: 50, exclusiveMinimum: true),
            'Expected result' => '{"type":"integer","minimum":50,"exclusiveMinimum":true}',
        ];
        yield 'Schema with maximum constraints' => [
            'Object' => new IntegerSchema(maximum: 10),
            'Expected result' => '{"type":"integer","maximum":10}',
        ];
        yield 'Schema with exclusive maximum constraints' => [
            'Object' => new IntegerSchema(exclusiveMaximum: 12),
            'Expected result' => '{"type":"integer","exclusiveMaximum":12}',
        ];
        yield 'Schema with exclusive maximum constraints (Draft-4 style)' => [
            'Object' => new IntegerSchema(maximum: 12, exclusiveMaximum: true),
            'Expected result' => '{"type":"integer","maximum":12,"exclusiveMaximum":true}',
        ];
    }
}
