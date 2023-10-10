<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Array;

use Gordinskiy\JsonSchema\Array\ArraySchema;
use Gordinskiy\JsonSchema\GenericSchema;
use Gordinskiy\JsonSchema\Numeric\IntegerSchema;
use Gordinskiy\JsonSchema\Numeric\NumberSchema;
use Gordinskiy\JsonSchema\String\StringFormat;
use Gordinskiy\JsonSchema\String\StringSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Webmozart\Assert\InvalidArgumentException;

final class ArraySchemaTest extends TestCase
{
    #[
        DataProvider('valid_schema_provider'),
        DataProvider('valid_generic_schema_provider')
    ]
    public function test_json_schema_format(ArraySchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_schema_provider(): \Generator
    {
        yield 'Array without any constraints' => [
            'Object' => new ArraySchema(),
            'Expected result' => '{"type":"array"}',
        ];
        yield 'Array with items constraint' => [
            'Object' => new ArraySchema(
                items: new StringSchema(format: StringFormat::Email)
            ),
            'Expected result' => '{"type":"array","items":{"type":"string","format":"email"}}',
        ];
        yield 'Array with prefixItem constraint' => [
            'Object' => new ArraySchema(
                prefixItems: [new StringSchema(), new IntegerSchema(), new GenericSchema(enum: ["NW", "NE", "SW", "SE"])]
            ),
            'Expected result' => '{"type":"array","prefixItems":[{"type":"string"},{"type":"integer"},{"enum":["NW","NE","SW","SE"]}]}',
        ];
        yield 'Array with contains constraint' => [
            'Object' => new ArraySchema(
                contains: new NumberSchema(const: 3.14)
            ),
            'Expected result' => '{"type":"array","contains":{"type":"number","const":3.14}}',
        ];
        yield 'Array with minContains constraint' => [
            'Object' => new ArraySchema(minContains: 6),
            'Expected result' => '{"type":"array","minContains":6}',
        ];
        yield 'Array with maxContains constraint' => [
            'Object' => new ArraySchema(maxContains: 3),
            'Expected result' => '{"type":"array","maxContains":3}',
        ];
        yield 'Array with minItems constraint' => [
            'Object' => new ArraySchema(minItems: 2),
            'Expected result' => '{"type":"array","minItems":2}',
        ];
        yield 'Array with maxItems constraint' => [
            'Object' => new ArraySchema(maxItems: 9),
            'Expected result' => '{"type":"array","maxItems":9}',
        ];
        yield 'Array with uniqueItems constraint' => [
            'Object' => new ArraySchema(uniqueItems: true),
            'Expected result' => '{"type":"array","uniqueItems":true}',
        ];
    }

    public static function valid_generic_schema_provider(): \Generator
    {
        yield 'Schema without constraints. With title' => [
            'Object' => new ArraySchema(title: 'Schema title'),
            'Expected result' => '{"type":"array","title":"Schema title"}',
        ];
        yield 'Schema without constraints. With description' => [
            'Object' => new ArraySchema(description: 'Schema without constraints'),
            'Expected result' => '{"type":"array","description":"Schema without constraints"}',
        ];
        yield 'Schema without constraints. With comment' => [
            'Object' => new ArraySchema(comment: 'Comment test'),
            'Expected result' => '{"type":"array","comment":"Comment test"}',
        ];
        yield 'Schema without constraints. With default value' => [
            'Object' => new ArraySchema(default: []),
            'Expected result' => '{"type":"array","default":[]}',
        ];
        yield 'Schema without constraints. With const value' => [
            'Object' => new ArraySchema(const: [5]),
            'Expected result' => '{"type":"array","const":[5]}',
        ];
        yield 'Schema without constraints. With examples' => [
            'Object' => new ArraySchema(examples: [[1, 2, 3], [4, 5, 6], [7, 8, 9]]),
            'Expected result' => '{"type":"array","examples":[[1,2,3],[4,5,6],[7,8,9]]}',
        ];
        yield 'Schema without constraints. Read only' => [
            'Object' => new ArraySchema(readOnly: true),
            'Expected result' => '{"type":"array","readOnly":true}',
        ];
        yield 'Schema without constraints. Write only' => [
            'Object' => new ArraySchema(writeOnly: true),
            'Expected result' => '{"type":"array","writeOnly":true}',
        ];
        yield 'Schema without constraints. Deprecated' => [
            'Object' => new ArraySchema(deprecated: true),
            'Expected result' => '{"type":"array","deprecated":true}',
        ];
        yield 'Schema with enum constraint.' => [
            'Object' => new ArraySchema(enum: [[0, 2, 4, 6, 8], [1, 3, 5, 7, 9]]),
            'Expected result' => '{"type":"array","enum":[[0,2,4,6,8],[1,3,5,7,9]]}',
        ];
    }
}
