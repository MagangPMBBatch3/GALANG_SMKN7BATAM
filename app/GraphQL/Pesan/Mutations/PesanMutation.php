<?php

namespace App\GraphQL\Pesan\Mutations;

use App\Models\Pesan\Pesan;

class PesanMutation 
{
    public function restore($_, array $args)
    {
        return Pesan::withTrashed()->find($args['id'])->restore()
            ? Pesan::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?Pesan
    {
        $pesan = Pesan::withTrashed()->find($args['id']);
        if ($pesan) {
            $pesan->forceDelete();
            return $pesan;
        }
        return null;
    }
}