<?php

declare(strict_types=1);

namespace Gordinskiy\JsonSchema\String;

/**
 * @link https://json-schema.org/understanding-json-schema/reference/string.html#built-in-formats
 */
enum StringFormat: string
{
    /**
     * @Example: 2018-11-13T20:20:39+00:00
     */
    case DateTime = 'date-time';

    /**
     * @Example: 20:20:39+00:00
     */
    case Time = 'time';

    /**
     * @Example: 2018-11-13
     */
    case Data = 'data';

    /**
     * ISO 8601
     * @Example: P3D
     */
    case Duration = 'duration';

    /**
     * RFC 5321, section 4.1.2.
     */
    case Email = 'email';

    /**
     * RFC 6531
     */
    case IdnEmail = 'idn-email';


    case Hostname = 'hostname';
    case IdnHostname = 'idn-hostname';


    case Ipv4 = 'ipv4';
    case Ipv6 = 'ipv6';


    case Uuid = 'uuid';
    case UriReference = 'uri-reference';
    case Iri = 'iri';
    case IriReference = 'iri-reference';


    case UriTemplate = 'uri-template';
    case JsonPointer = 'json-pointer';
    case RelativeJsonPointer = 'relative-json-pointer';
    case Regex = 'regex';
}
