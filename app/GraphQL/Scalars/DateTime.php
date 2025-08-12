<?php


namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\ScalarType;
use Carbon\Carbon;

class DateTime extends ScalarType
{
    public string $name = 'DateTime';

    public function serialize($value)
    {
        return $value instanceof Carbon ? $value->toIso8601String() : (string) $value;
    }

    public function parseValue($value)
    {
        return Carbon::parse($value);
    }

    public function parseLiteral($valueNode, ?array $variables = null)
    {
        return Carbon::parse($valueNode->value);
    }
}