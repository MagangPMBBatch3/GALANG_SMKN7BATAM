<?php

namespace App\GraphQL\JenisPesan\Mutations;

use App\Models\JenisPesan\JenisPesan;

class JenisPesanMutation 
{
    public function restore($_, array $args)
    {
        return JenisPesan::withTrashed()->find($args['id'])->restore()
            ? JenisPesan::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?JenisPesan
    {
        $jenisPesan = JenisPesan::withTrashed()->find($args['id']);
        if ($jenisPesan) {
            $jenisPesan->forceDelete();
            return $jenisPesan;
        }
        return null;
    }
}