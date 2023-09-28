<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\String;

use Gordinskiy\JsonSchema\String\StringFormat;
use Gordinskiy\JsonSchema\String\StringSchema;
use Gordinskiy\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Webmozart\Assert\InvalidArgumentException;

final class StringSchemaTest extends TestCase
{
    #[
        DataProvider('valid_string_without_constraints'),
        DataProvider('valid_strings_with_minimal_length_constraints'),
        DataProvider('valid_strings_with_maximum_length_constraints'),
        DataProvider('valid_strings_with_combined_length_constraints'),
    ]
    public function test_valid_boolean(string $value, StringSchema $schema): void
    {
        self::assertEmpty(
            $this->validate(
                $value,
                json_encode($schema)
            )
        );
    }

    public static function valid_string_without_constraints(): \Generator
    {
        yield 'String schema without constrains. Empty string' => [
            'string' => '',
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Non-empty string' => [
            'string' => 'Some string',
            'schema' => new StringSchema(),
        ];
    }

    public static function valid_strings_with_minimal_length_constraints(): \Generator
    {
        yield 'String zero minLength constraint. Empty string' => [
            'string' => '',
            'schema' => new StringSchema(minLength: 0),
        ];
        yield 'String zero minLength constraint. Non-empty string' => [
            'string' => 'Some string',
            'schema' => new StringSchema(minLength: 0),
        ];
        yield 'String zero minLength constraint. String with minimal valid length' => [
            'string' => 's',
            'schema' => new StringSchema(minLength: 1),
        ];
    }

    public static function valid_strings_with_maximum_length_constraints(): \Generator
    {
        yield 'String zero maxLength constraint. Empty string' => [
            'string' => '',
            'schema' => new StringSchema(maxLength: 0),
        ];
        yield 'String non-zero maxLength constraint. Empty string' => [
            'string' => '',
            'schema' => new StringSchema(maxLength: 1),
        ];
        yield 'String non-zero maxLength constraint. Non-empty string' => [
            'string' => 's',
            'schema' => new StringSchema(maxLength: 1),
        ];
        yield 'String non-zero maxLength constraint. String with maximum valid length' => [
            'string' => 'String',
            'schema' => new StringSchema(minLength: 6),
        ];
    }

    public static function valid_strings_with_combined_length_constraints(): \Generator
    {
        yield 'String combined length constraint. Shortest valid string' => [
            'string' => 'Shortest valid string',
            'schema' => new StringSchema(minLength: 21, maxLength: 31),
        ];
        yield 'String combined length constraint. Longest valid string' => [
            'string' => 'Longest valid string',
            'schema' => new StringSchema(minLength: 3, maxLength: 20),
        ];
        yield 'String strict length constraint. The only one valid string' => [
            'string' => 'Equality',
            'schema' => new StringSchema(minLength: 8, maxLength: 8),
        ];
    }

    #[
        DataProvider('invalid_string_without_constraints'),
        DataProvider('invalid_strings_with_minimal_length_constraints'),
        DataProvider('invalid_strings_with_maximal_length_constraints'),
        DataProvider('invalid_strings_with_combined_length_constraints'),
    ]
    public function test_invalid_boolean(mixed $value, StringSchema $schema): void
    {
        self::assertNotEmpty(
            $this->validate(
                $value,
                json_encode($schema)
            )
        );
    }

    public static function invalid_string_without_constraints(): \Generator
    {
        yield 'String schema without constrains. Null instead of string' => [
            'string' => null,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Boolean true instead of string' => [
            'string' => true,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Boolean false instead of string' => [
            'string' => false,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Empty array instead of string' => [
            'string' => [],
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Non-empty array instead of string' => [
            'string' => ['string'],
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Zero integer instead of string' => [
            'string' => 0,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Positive integer instead of string' => [
            'string' => 10,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Negative integer instead of string' => [
            'string' => -10,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Zero float instead of string' => [
            'string' => 0.0,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Positive float instead of string' => [
            'string' => 10.1,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Negative float instead of string' => [
            'string' => -10.1,
            'schema' => new StringSchema(),
        ];
        yield 'String schema without constrains. Object instead of string' => [
            'string' => new \stdClass(),
            'schema' => new StringSchema(),
        ];
    }

    public static function invalid_strings_with_minimal_length_constraints(): \Generator
    {
        yield 'String with minLength constraint. Empty string' => [
            'string' => '',
            'schema' => new StringSchema(minLength: 1),
        ];
        yield 'String with minLength constraint. Longest invalid string' => [
            'string' => 'string',
            'schema' => new StringSchema(minLength: 7),
        ];
    }

    public static function invalid_strings_with_maximal_length_constraints(): \Generator
    {
        yield 'String with zero maxLength constraint. Shortest invalid string' => [
            'string' => 'c',
            'schema' => new StringSchema(maxLength: 0),
        ];
        yield 'String with non-zero maxLength constraint. Shortest invalid string' => [
            'string' => 'Some string',
            'schema' => new StringSchema(maxLength: 10),
        ];
    }

    public static function invalid_strings_with_combined_length_constraints(): \Generator
    {
        yield 'String with combined length constraint. Shortest invalid string' => [
            'string' => 'Some string',
            'schema' => new StringSchema(minLength: 5, maxLength: 10),
        ];
        yield 'String with combined length constraint. Longest invalid string' => [
            'string' => 'String',
            'schema' => new StringSchema(minLength: 7, maxLength: 10),
        ];
    }

    public function test_negative_min_length_constrain(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('String min length constrain value must be a non-negative number.');

        new StringSchema(minLength: -1);
    }

    public function test_negative_max_length_constrain(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('String max length constrain value must be a non-negative number.');

        new StringSchema(maxLength: -1);
    }

    public function test_conflict_length_constrain(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('String min length constrain cant be greater than max length constrain.');

        new StringSchema(minLength: 100, maxLength: 5);
    }

    #[
        DataProvider('valid_string_schema_provider'),
        DataProvider('valid_string_generic_schema_provider'),
    ]
    public function test_json_schema_format(StringSchema $schemaObject, string $expectedResult): void
    {
        self::assertSame(
            expected: $expectedResult,
            actual: json_encode($schemaObject),
        );
    }

    public static function valid_string_schema_provider(): \Generator
    {
        yield 'Schema without constraints' => [
            'Object' => new StringSchema(),
            'Expected result' => '{"type":"string"}',
        ];
        yield 'Schema with min length constraint' => [
            'Object' => new StringSchema(minLength: 100),
            'Expected result' => '{"type":"string","minLength":100}',
        ];
        yield 'Schema with max length constraint' => [
            'Object' => new StringSchema(maxLength: 24),
            'Expected result' => '{"type":"string","maxLength":24}',
        ];
        yield 'Schema with pattern constraint' => [
            'Object' => new StringSchema(pattern: '^[0-9]{5}(?:-[0-9]{4})?$'),
            'Expected result' => '{"type":"string","pattern":"^[0-9]{5}(?:-[0-9]{4})?$"}',
        ];
        yield 'Schema with format constraint' => [
            'Object' => new StringSchema(format: StringFormat::Email),
            'Expected result' => '{"type":"string","format":"email"}',
        ];
    }

    public static function valid_string_generic_schema_provider(): \Generator
    {
        yield 'Schema without constraints. With title' => [
            'Object' => new StringSchema(title: 'Schema title'),
            'Expected result' => '{"type":"string","title":"Schema title"}',
        ];
        yield 'Schema without constraints. With description' => [
            'Object' => new StringSchema(description: 'Schema without constraints'),
            'Expected result' => '{"type":"string","description":"Schema without constraints"}',
        ];
        yield 'Schema without constraints. With comment' => [
            'Object' => new StringSchema(comment: 'Comment test'),
            'Expected result' => '{"type":"string","comment":"Comment test"}',
        ];
        yield 'Schema without constraints. With default value' => [
            'Object' => new StringSchema(default: 'Nameless'),
            'Expected result' => '{"type":"string","default":"Nameless"}',
        ];
        yield 'Schema without constraints. With const value' => [
            'Object' => new StringSchema(const: 'None'),
            'Expected result' => '{"type":"string","const":"None"}',
        ];
        yield 'Schema without constraints. With examples' => [
            'Object' => new StringSchema(examples: ['Monday', 'Sunday']),
            'Expected result' => '{"type":"string","examples":["Monday","Sunday"]}',
        ];
        yield 'Schema without constraints. Read only' => [
            'Object' => new StringSchema(readOnly: true),
            'Expected result' => '{"type":"string","readOnly":true}',
        ];
        yield 'Schema without constraints. Write only' => [
            'Object' => new StringSchema(writeOnly: true),
            'Expected result' => '{"type":"string","writeOnly":true}',
        ];
        yield 'Schema without constraints. Deprecated' => [
            'Object' => new StringSchema(deprecated: true),
            'Expected result' => '{"type":"string","deprecated":true}',
        ];
        yield 'Schema with enum constraint.' => [
            'Object' => new StringSchema(enum: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'Expected result' => '{"type":"string","enum":["Monday","Tuesday","Wednesday","Thursday","Friday"]}',
        ];
    }
}
