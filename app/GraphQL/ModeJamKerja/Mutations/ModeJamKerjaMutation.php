<?php

namespace App\GraphQL\ModeJamKerja\Mutations;

use App\Models\ModeJamKerja\ModeJamKerja;

class ModeJamKerjaMutation 
{
    public function restore($_, array $args)
    {
        return ModeJamKerja::withTrashed()->find($args['id'])->restore()
            ? ModeJamKerja::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?ModeJamKerja
    {
        $modeJamKerja = ModeJamKerja::withTrashed()->find($args['id']);
        if ($modeJamKerja) {
            $modeJamKerja->forceDelete();
            return $modeJamKerja;
        }
        return null;
    }
}