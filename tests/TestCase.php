<?php

declare(strict_types=1);

namespace Gordinskiy\Tests;

use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    public function validate(
        mixed $value,
        string $jsonSchema,
    ): array {
        $schemaStorage = new SchemaStorage();
        $schemaStorage->addSchema('file://mySchema', $jsonSchema);
        $jsonValidator = new Validator(new Factory($schemaStorage));
        $jsonToValidateObject = $value;
        $jsonValidator->validate($jsonToValidateObject, json_decode($jsonSchema));

        return $jsonValidator->getErrors();
    }
}
