<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Boolean;

use Gordinskiy\JsonSchema\Boolean\BooleanSchema;
use PHPUnit\Framework\Attributes\DataProvider;
use Gordinskiy\Tests\TestCase;

final class BooleanSchemaTest extends TestCase
{
    #[DataProvider('valid_boolean_provider')]
    public function test_valid_boolean(bool $value): void
    {
        self::assertEmpty(
            $this->validate(
                $value,
                json_encode(new BooleanSchema())
            )
        );
    }

    #[DataProvider('invalid_boolean_provider')]
    public function test_invalid_boolean(string|int|float $value): void
    {
        self::assertNotEmpty(
            $this->validate(
                $value,
                json_encode(new BooleanSchema())
            )
        );
    }

    public static function valid_boolean_provider(): \Generator
    {
        yield [true];
        yield [false];
    }

    public static function invalid_boolean_provider(): \Generator
    {
        yield ['true'];
        yield ['false'];
        yield ['0'];
        yield [0];
        yield [0.0];
        yield ['1'];
        yield [1];
        yield [1.0];
    }

    #[
        DataProvider('valid_boolean_schema_provider'),
        DataProvider('valid_boolean_generic_schema_provider'),
    ]
    public function test_json_schema_format(BooleanSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_boolean_schema_provider(): \Generator
    {
        yield 'Schema without constraints' => [
            'Object' => new BooleanSchema(),
            'Expected result' => '{"type":"boolean"}',
        ];
    }

    public static function valid_boolean_generic_schema_provider(): \Generator
    {
        yield 'Schema without constraints. With title' => [
            'Object' => new BooleanSchema(title: 'Schema title'),
            'Expected result' => '{"type":"boolean","title":"Schema title"}',
        ];
        yield 'Schema without constraints. With description' => [
            'Object' => new BooleanSchema(description: 'Schema without constraints'),
            'Expected result' => '{"type":"boolean","description":"Schema without constraints"}',
        ];
        yield 'Schema without constraints. With comment' => [
            'Object' => new BooleanSchema(comment: 'Comment test'),
            'Expected result' => '{"type":"boolean","comment":"Comment test"}',
        ];
        yield 'Schema without constraints. With default value' => [
            'Object' => new BooleanSchema(default: false),
            'Expected result' => '{"type":"boolean","default":false}',
        ];
        yield 'Schema without constraints. With const value' => [
            'Object' => new BooleanSchema(const: false),
            'Expected result' => '{"type":"boolean","const":false}',
        ];
        yield 'Schema without constraints. With examples' => [
            'Object' => new BooleanSchema(examples: [false, true]),
            'Expected result' => '{"type":"boolean","examples":[false,true]}',
        ];
        yield 'Schema without constraints. Read only' => [
            'Object' => new BooleanSchema(readOnly: true),
            'Expected result' => '{"type":"boolean","readOnly":true}',
        ];
        yield 'Schema without constraints. Write only' => [
            'Object' => new BooleanSchema(writeOnly: true),
            'Expected result' => '{"type":"boolean","writeOnly":true}',
        ];
        yield 'Schema without constraints. Deprecated' => [
            'Object' => new BooleanSchema(deprecated: true),
            'Expected result' => '{"type":"boolean","deprecated":true}',
        ];
        yield 'Schema with enum constraint.' => [
            'Object' => new BooleanSchema(enum: [false, true]),
            'Expected result' => '{"type":"boolean","enum":[false,true]}',
        ];
    }
}
