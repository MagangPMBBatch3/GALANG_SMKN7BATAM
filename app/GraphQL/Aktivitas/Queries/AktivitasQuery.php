<?php

namespace App\GraphQL\Aktivitas\Queries;

use App\Models\Aktivitas\Aktivitas;

class AktivitasQuery
{
    public function all($_, array $args)
    {
        $query = Aktivitas::query();

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
