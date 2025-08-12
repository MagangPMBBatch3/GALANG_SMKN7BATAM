<?php

namespace App\GraphQL\Aktivitas\Mutations;

use App\Models\Aktivitas\Aktivitas;

class AktivitasMutation 
{
    public function restore($_, array $args)
    {
        return Aktivitas::withTrashed()->find($args['id'])->restore()
            ? Aktivitas::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?Aktivitas
    {
        $aktivitas = Aktivitas::withTrashed()->find($args['id']);
        if ($aktivitas) {
            $aktivitas->forceDelete();
            return $aktivitas;
        }
        return null;
    }
}