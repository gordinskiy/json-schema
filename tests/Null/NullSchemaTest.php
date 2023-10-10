<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Null;

use Gordinskiy\JsonSchema\Null\NullSchema;
use PHPUnit\Framework\Attributes\DataProvider;
use Gordinskiy\Tests\TestCase;

final class NullSchemaTest extends TestCase
{
    #[
        DataProvider('valid_schema_provider'),
    ]
    public function test_json_schema_format(NullSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_schema_provider(): \Generator
    {
        yield 'Schema without constraints' => [
            'Object' => new NullSchema(),
            'Expected result' => '{"type":"null"}',
        ];
    }
}
