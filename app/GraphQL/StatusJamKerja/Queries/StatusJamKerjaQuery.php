<?php

namespace App\GraphQL\StatusJamKerja\Queries;

use App\Models\StatusJamKerja\StatusJamKerja;

class StatusJamKerjaQuery
{


    public function allStatusJamKerjaArsip($_, array $args)
    {
        return StatusJamKerja::onlyTrashed()->get();
    }

    public function all($_, array $args)
    {
        $query = StatusJamKerja::query();

        if (!empty($args['search'])) {
            $query->where('nama', 'like', '%' . $args['search'] . '%');
        }

        $perPage = $args['first'] ?? 10;
        $page = $args['page'] ?? 1;

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'data' => $paginator->items(),
            'paginatorInfo' => [
                'hasMorePages' => $paginator->hasMorePages(),
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ];
    }
}