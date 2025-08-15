<?php

namespace App\GraphQL\UserProfile\Queries;

use App\Models\UserProfile\UserProfile;

class UserProfileQuery {
    public function userProfileByUserId($_, array $args)
    {
        return UserProfile::where('user_id', $args['user_id'])->first();
    }
}