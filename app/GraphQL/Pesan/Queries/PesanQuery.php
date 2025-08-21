<?php

namespace App\GraphQL\Pesan\Queries;

use App\Models\Pesan\Pesan;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class PesanQuery
{
    public function pesansByUserProfile($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Pesan::where(function ($query) use ($args) {
            $query->where('pengirim_id', $args['user_profile_id'])
                  ->orWhere('penerima_id', $args['user_profile_id']);
        })->with(['pengirim', 'penerima', 'jenis'])->get();
    }
}