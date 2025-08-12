<?php

namespace App\GraphQL\Status\Mutations;

use App\Models\Status\Statuses;

class StatusMutation
{

     public function restore($_, array $args)
    {
        $Status = Statuses::withTrashed()->findOrFail($args['id']);
        $Status->restore();
        return $Status;
    }

     public function forceDelete($_, array $args)
    {
        $Status = Statuses::withTrashed()->findOrFail($args['id']);
        $Status->forceDelete();
        return $Status;
    }

    
}
