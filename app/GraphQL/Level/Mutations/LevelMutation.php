<?php

namespace App\GraphQL\Level\Mutations;

use App\Models\Level\Levels;

class LevelMutation {

    public function restore($_, array $args)
    {
        $level = Levels::withTrashed()->findOrFail($args['id']);
        $level->restore();
        return $level;
    }

    public function forceDelete($_, array $args)
    {
        $level = Levels::withTrashed()->findOrFail($args['id']);
        $level->forceDelete();
        return $level;
    }
}
