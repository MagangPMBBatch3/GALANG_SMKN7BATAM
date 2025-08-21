<?php
namespace App\GraphQL\Pesan\Subscriptions;

use App\Models\Pesan\Pesan;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;

class PesanSubscription
{
    public function messageCreated($root, array $args)
    {
        return Pesan::where('penerima_id', $args['user_profile_id'])->latest()->first();
    }
}