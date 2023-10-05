<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Object;

use Gordinskiy\JsonSchema\Numeric\IntegerSchema;
use Gordinskiy\JsonSchema\Object\ObjectProperties;
use Gordinskiy\JsonSchema\Object\ObjectProperty;
use Gordinskiy\JsonSchema\Object\ObjectSchema;
use Gordinskiy\JsonSchema\String\StringSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Webmozart\Assert\InvalidArgumentException;

final class ObjectSchemaTest extends TestCase
{
    #[
        DataProvider('valid_schema_provider'),
        DataProvider('valid_number_generic_schema_provider')
    ]
    public function test_json_schema_format(ObjectSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_schema_provider(): \Generator
    {
        yield 'Object without any constraints' => [
            'Object' => new ObjectSchema(),
            'Expected result' => '{"type":"object"}',
        ];
        yield 'Object with one property' => [
            'Object' => new ObjectSchema(
                properties: new ObjectProperties(new ObjectProperty('email', new StringSchema()))
            ),
            'Expected result' => '{"type":"object","properties":{"email":{"type":"string"}}}',
        ];
        yield 'Object with two properties' => [
            'Object' => new ObjectSchema(
                properties: new ObjectProperties(
                    new ObjectProperty('email', new StringSchema()),
                    new ObjectProperty('name', new StringSchema()),
                )
            ),
            'Expected result' => '{"type":"object","properties":{"email":{"type":"string"},"name":{"type":"string"}}}',
        ];

        yield 'Object with one patternProperty' => [
            'Object' => new ObjectSchema(
                patternProperties: new ObjectProperties(new ObjectProperty('^S_', new StringSchema()))
            ),
            'Expected result' => '{"type":"object","patternProperties":{"^S_":{"type":"string"}}}',
        ];
        yield 'Object with two patternProperties' => [
            'Object' => new ObjectSchema(
                patternProperties: new ObjectProperties(
                    new ObjectProperty('^S_', new StringSchema()),
                    new ObjectProperty('^I_', new IntegerSchema()),
                )
            ),
            'Expected result' => '{"type":"object","patternProperties":{"^S_":{"type":"string"},"^I_":{"type":"integer"}}}',
        ];
        yield 'Object with property name constraint' => [
            'Object' => new ObjectSchema(
                propertyNames: new StringSchema(minLength: 3),
            ),
            'Expected result' => '{"type":"object","propertyNames":{"type":"string","minLength":3}}',
        ];
        yield 'Object with minProperties constraint' => [
            'Object' => new ObjectSchema(
                minProperties: 5,
            ),
            'Expected result' => '{"type":"object","minProperties":5}',
        ];
        yield 'Object with maxProperties constraint' => [
            'Object' => new ObjectSchema(
                maxProperties: 2,
            ),
            'Expected result' => '{"type":"object","maxProperties":2}',
        ];
        yield 'Object with required properties' => [
            'Object' => new ObjectSchema(
                required: ['email', 'name'],
            ),
            'Expected result' => '{"type":"object","required":["email","name"]}',
        ];
        yield 'Object with additionalProperties disabled' => [
            'Object' => new ObjectSchema(
                additionalProperties: false,
            ),
            'Expected result' => '{"type":"object","additionalProperties":false}',
        ];
        yield 'Object with additionalProperties constraint' => [
            'Object' => new ObjectSchema(
                additionalProperties: new StringSchema(),
            ),
            'Expected result' => '{"type":"object","additionalProperties":{"type":"string"}}',
        ];
        yield 'Object with unevaluatedProperties enabled' => [
            'Object' => new ObjectSchema(
                unevaluatedProperties: true,
            ),
            'Expected result' => '{"type":"object","unevaluatedProperties":true}',
        ];
    }

    public static function valid_number_generic_schema_provider(): \Generator
    {
        yield 'Schema without constraints. With title' => [
            'Object' => new ObjectSchema(title: 'Schema title'),
            'Expected result' => '{"type":"object","title":"Schema title"}',
        ];
        yield 'Schema without constraints. With description' => [
            'Object' => new ObjectSchema(description: 'Schema without constraints'),
            'Expected result' => '{"type":"object","description":"Schema without constraints"}',
        ];
        yield 'Schema without constraints. With comment' => [
            'Object' => new ObjectSchema(comment: 'Comment test'),
            'Expected result' => '{"type":"object","comment":"Comment test"}',
        ];
        yield 'Schema without constraints. With default value' => [
            'Object' => new ObjectSchema(default: new class {}),
            'Expected result' => '{"type":"object","default":{}}',
        ];
        yield 'Schema without constraints. With const value' => [
            'Object' => new ObjectSchema(const: new class {public $value = 3.14;}),
            'Expected result' => '{"type":"object","const":{"value":3.14}}',
        ];
        yield 'Schema without constraints. With examples' => [
            'Object' => new ObjectSchema(examples: [new class {public $id = 1;}]),
            'Expected result' => '{"type":"object","examples":[{"id":1}]}',
        ];
        yield 'Schema without constraints. Read only' => [
            'Object' => new ObjectSchema(readOnly: true),
            'Expected result' => '{"type":"object","readOnly":true}',
        ];
        yield 'Schema without constraints. Write only' => [
            'Object' => new ObjectSchema(writeOnly: true),
            'Expected result' => '{"type":"object","writeOnly":true}',
        ];
        yield 'Schema without constraints. Deprecated' => [
            'Object' => new ObjectSchema(deprecated: true),
            'Expected result' => '{"type":"object","deprecated":true}',
        ];
        yield 'Schema with enum constraint.' => [
            'Object' => new ObjectSchema(enum: [new class {public $id = 1;},new class {public $id = 2;}]),
            'Expected result' => '{"type":"object","enum":[{"id":1},{"id":2}]}',
        ];
    }

    public function test_negative_min_properties(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Object minProperties constrain value must be a non-negative number.');

        new ObjectSchema(minProperties: -1);
    }

    public function test_negative_max_properties(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Object maxProperties constrain value must be a non-negative number.');

        new ObjectSchema(maxProperties: -1);
    }

    public function test_min_properties_greater_than_max_properties(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Object minProperties constrain cant be greater than maxProperties constrain.');

        new ObjectSchema(minProperties: 10, maxProperties: 2);
    }
}
