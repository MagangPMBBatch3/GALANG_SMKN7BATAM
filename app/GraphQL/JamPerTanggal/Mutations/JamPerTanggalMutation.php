<?php

namespace App\GraphQL\JamPerTanggal\Mutations;

use App\Models\JamPerTanggal\JamPerTanggal;

class JamPerTanggalMutation 
{
    public function restore($_, array $args)
    {
        return JamPerTanggal::withTrashed()->find($args['id'])->restore()
            ? JamPerTanggal::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?JamPerTanggal
    {
        $jamPerTanggal = JamPerTanggal::withTrashed()->find($args['id']);
        if ($jamPerTanggal) {
            $jamPerTanggal->forceDelete();
            return $jamPerTanggal;
        }
        return null;
    }
}