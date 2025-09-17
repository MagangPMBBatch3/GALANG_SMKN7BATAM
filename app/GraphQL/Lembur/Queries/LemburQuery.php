<?php

namespace App\GraphQL\Lembur\Queries;

use App\Models\Lembur\Lembur;

class LemburQuery
{
    public function all($_, array $args)
    {
        $query = Lembur::query();

        if (!empty($args['search'])) {
            $query->where('keterangan', 'like', '%' . $args['search'] . '%');
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