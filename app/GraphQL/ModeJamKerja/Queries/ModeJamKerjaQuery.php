<?php

namespace App\GraphQL\ModeJamKerja\Queries;

use App\Models\ModeJamKerja\ModeJamKerja;

class ModeJamKerjaQuery
{


    public function allModeJamKerjaArsip($_, array $args)
    {
        return ModeJamKerja::onlyTrashed()->get();
    }
}