<?php

namespace App\GraphQL\StatusJamKerja\Queries;

use App\Models\StatusJamKerja\StatusJamKerja;

class StatusJamKerjaQuery
{


    public function allStatusJamKerjaArsip($_, array $args)
    {
        return StatusJamKerja::onlyTrashed()->get();
    }
}