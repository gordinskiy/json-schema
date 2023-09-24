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

    #[DataProvider('valid_boolean_schema_provider')]
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
}
