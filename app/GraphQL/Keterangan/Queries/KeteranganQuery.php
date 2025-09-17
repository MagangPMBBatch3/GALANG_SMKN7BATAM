<?php

namespace App\GraphQL\Keterangan\Queries;

use App\Models\Keterangan\Keterangan;

class KeteranganQuery
{


    public function allKeteranganArsip($_, array $args)
    {
        return Keterangan::onlyTrashed()->get();
    }

    public function all($_, array $args)
    {
        $query = Keterangan::query();

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