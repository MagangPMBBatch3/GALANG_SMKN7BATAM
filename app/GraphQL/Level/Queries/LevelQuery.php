<?php

namespace App\GraphQL\Level\Queries;

use App\Models\Level\Levels;
    
class LevelQuery
{
    public function allLevelArsip($_, array $args)
    {
        return Levels::onlyTrashed()->get();
    }
}