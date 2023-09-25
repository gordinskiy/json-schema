<?php

declare(strict_types=1);

namespace Composition;

use Gordinskiy\JsonSchema\Boolean\BooleanSchema;
use Gordinskiy\JsonSchema\Composition\OneOfSchema;
use Gordinskiy\JsonSchema\Numeric\IntegerSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class OneOfSchemaTest extends TestCase
{
    #[DataProvider('valid_schema_provider')]
    public function test_json_schema_format(OneOfSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_schema_provider(): \Generator
    {
        yield 'Integer or Boolean constraint' => [
            'Object' => new OneOfSchema(new IntegerSchema(), new BooleanSchema()),
            'Expected result' => '{"oneOf":[{"type":"integer"},{"type":"boolean"}]}',
        ];
    }
}
