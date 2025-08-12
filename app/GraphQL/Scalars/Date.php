<?php

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\ScalarType;
use Carbon\Carbon;

class Date extends ScalarType
{
    public string $name = 'Date';

    public function serialize($value)
    {
        return $value instanceof Carbon ? $value->toDateString() : (string) $value;
    }

    public function parseValue($value)
    {
        return Carbon::parse($value)->startOfDay();
    }

    public function parseLiteral($valueNode, ?array $variables = null)
    {
        return Carbon::parse($valueNode->value)->startOfDay();
    }
}