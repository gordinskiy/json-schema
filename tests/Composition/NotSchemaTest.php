<?php

declare(strict_types=1);

namespace Composition;

use Gordinskiy\JsonSchema\Boolean\BooleanSchema;
use Gordinskiy\JsonSchema\Composition\NotSchema;
use Gordinskiy\JsonSchema\GenericSchema;
use Gordinskiy\JsonSchema\Numeric\IntegerSchema;
use Gordinskiy\JsonSchema\Numeric\NumberSchema;
use Gordinskiy\JsonSchema\String\StringSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class NotSchemaTest extends TestCase
{
    #[
        DataProvider('valid_negation_constraints')
    ]
    public function test_valid_negation(mixed $value, NotSchema $schema): void
    {
        self::assertEmpty(
            $this->validate(
                $value,
                json_encode($schema)
            )
        );
    }

    public static function valid_negation_constraints(): \Generator
    {
        yield 'String is not an Integer' => [
            'value' => '6',
            'schema' => new NotSchema(new IntegerSchema()),
        ];
        yield 'Float is not an Integer' => [
            'value' => 6.6,
            'schema' => new NotSchema(new IntegerSchema()),
        ];
        yield 'Bool is not an Integer' => [
            'value' => false,
            'schema' => new NotSchema(new IntegerSchema()),
        ];
        yield 'Null is not an Integer' => [
            'value' => null,
            'schema' => new NotSchema(new IntegerSchema()),
        ];
        yield 'Odd integer is not an Even Integer' => [
            'value' => 7,
            'schema' => new NotSchema(new IntegerSchema(multipleOf: 2)),
        ];
        yield 'Value is not from Enum' => [
            'value' => 'Monday',
            'schema' => new NotSchema(new GenericSchema(enum: ['March', 'April', 'May'])),
        ];
        yield 'Double negation' => [
            'value' => 25,
            'schema' => new NotSchema(new NotSchema(new IntegerSchema())),
        ];
        yield 'Triple negation' => [
            'value' => false,
            'schema' => new NotSchema(new NotSchema(new NotSchema(new IntegerSchema()))),
        ];
    }
    #[
        DataProvider('invalid_negation_constraints')
    ]
    public function test_invalid_negation(mixed $value, NotSchema $schema): void
    {
        self::assertNotEmpty(
            $this->validate(
                $value,
                json_encode($schema)
            )
        );
    }

    public static function invalid_negation_constraints(): \Generator
    {
        yield 'String is not a String' => [
            'value' => '6',
            'schema' => new NotSchema(new StringSchema()),
        ];
        yield 'Float is not a Float' => [
            'value' => 6.6,
            'schema' => new NotSchema(new NumberSchema()),
        ];
        yield 'Bool is not an Integer' => [
            'value' => false,
            'schema' => new NotSchema(new BooleanSchema()),
        ];
        yield 'Odd integer is not an Odd integer' => [
            'value' => 4,
            'schema' => new NotSchema(new IntegerSchema(multipleOf: 2)),
        ];
        yield 'Value from Enum is not from Enum' => [
            'value' => 'April',
            'schema' => new NotSchema(new GenericSchema(enum: ['March', 'April', 'May'])),
        ];
    }

    #[DataProvider('valid_not_schema_provider')]
    public function test_json_schema_format(NotSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_not_schema_provider(): \Generator
    {
        yield 'Schema with the constraint not to be a string' => [
            'Object' => new NotSchema(new StringSchema()),
            'Expected result' => '{"not":{"type":"string"}}',
        ];
        yield 'Schema with the constraint not to be an odd integer' => [
            'Object' => new NotSchema(new IntegerSchema(multipleOf: 2)),
            'Expected result' => '{"not":{"type":"integer","multipleOf":2}}',
        ];
    }
}
