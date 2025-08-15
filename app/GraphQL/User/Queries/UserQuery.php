<?php

namespace App\GraphQL\User\Queries;

use App\Models\User\User;

class UserQuery
{
    

    public function allUserArsip($_, array $args)
    {
        return User::onlyTrashed()->get();
    }


}