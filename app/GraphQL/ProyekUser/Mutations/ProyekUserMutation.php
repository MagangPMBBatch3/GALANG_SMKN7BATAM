<?php

namespace App\GraphQL\ProyekUser\Mutations;

use App\Models\ProyekUser\ProyekUser;

class ProyekUserMutation 
{
    public function restore($_, array $args)
    {
        return ProyekUser::withTrashed()->find($args['id'])->restore()
            ? ProyekUser::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?ProyekUser
    {
        $proyekUser = ProyekUser::withTrashed()->find($args['id']);
        if ($proyekUser) {
            $proyekUser->forceDelete();
            return $proyekUser;
        }
        return null;
    }
}