<?php

declare(strict_types=1);

namespace Composition;

use Gordinskiy\JsonSchema\Composition\AllOfSchema;
use Gordinskiy\JsonSchema\String\StringFormat;
use Gordinskiy\JsonSchema\String\StringSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class AllOfSchemaTest extends TestCase
{
    #[DataProvider('valid_schema_provider')]
    public function test_json_schema_format(AllOfSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_schema_provider(): \Generator
    {
        yield 'Email with minimal length' => [
            'Object' => new AllOfSchema(
                new StringSchema(format: StringFormat::Email),
                new StringSchema(minLength: 16)
            ),
            'Expected result' => '{"allOf":[{"type":"string","format":"email"},{"type":"string","minLength":16}]}',
        ];
    }
}
