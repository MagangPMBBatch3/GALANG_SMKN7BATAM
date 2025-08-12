<?php

namespace App\GraphQL\StatusJamKerja\Mutations;

use App\Models\StatusJamKerja\StatusJamKerja;

class StatusJamKerjaMutation 
{
    public function restore($_, array $args)
    {
        return StatusJamKerja::withTrashed()->find($args['id'])->restore()
            ? StatusJamKerja::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?StatusJamKerja
    {
        $statusJamKerja = StatusJamKerja::withTrashed()->find($args['id']);
        if ($statusJamKerja) {
            $statusJamKerja->forceDelete();
            return $statusJamKerja;
        }
        return null;
    }
}