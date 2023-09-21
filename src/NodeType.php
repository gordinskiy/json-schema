<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/type.html
 */
enum NodeType: string
{
    case String = 'string';
    case Integer = 'integer';
    case Number = 'number';
    case Object = 'object';
    case Array = 'array';
    case Boolean = 'boolean';
    case Null = 'null';
}
