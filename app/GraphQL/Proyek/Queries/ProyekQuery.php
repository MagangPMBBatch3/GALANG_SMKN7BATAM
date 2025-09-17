<?php

namespace App\GraphQL\Proyek\Queries;

use App\Models\Proyek\Proyek;

class ProyekQuery
{
    public function getProyeks($_, array $args)
    {
        $query = Proyek::query();

        if (!empty($args['search'])) {
           $query->where('id', 'like', '%' . $args['search'] . '%')
                 ->orWhere('kode', 'like', '%' . $args['search'] . '%')
                 ->orWhere('nama', 'like', '%' . $args['search'] . '%')
                 ->orWhere('nama_sekolah', 'like', '%' . $args['search'] . '%');
        }

        return $query->get();

       
    }

    public function allProyekArsip($_, array $args)
    {
        return Proyek::onlyTrashed()->get();
    }

    public function all($_, array $args)
    {
        $query = Proyek::query();

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