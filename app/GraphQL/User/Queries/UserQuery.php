<?php

namespace App\GraphQL\User\Queries;

use App\Models\User\User;

class UserQuery
{
    

    public function allUserArsip($_, array $args)
    {
        return User::onlyTrashed()->get();
    }

    public function all($_, array $args)
    {
        $query = User::query();

        if (!empty($args['search'])) {
            $query->where('name', 'like', '%' . $args['search'] . '%')
                  ->orWhere('email', 'like', '%' . $args['search'] . '%');
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