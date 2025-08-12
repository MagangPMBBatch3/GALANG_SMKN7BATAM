<?php

namespace App\GraphQL\JamKerja\Mutations;

use App\Models\JamKerja\JamKerja;

class JamKerjaMutation
{
    public function restore($_, array $args)
    {
        return JamKerja::withTrashed()->find($args['id'])->restore()
            ? JamKerja::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?JamKerja
    {
        $jamKerja = JamKerja::withTrashed()->find($args['id']);
        if ($jamKerja) {
            $jamKerja->forceDelete();
            return $jamKerja;
        }
        return null;
    }
}