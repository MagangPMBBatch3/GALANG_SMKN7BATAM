<?php

namespace App\GraphQL\User\Mutations;

use App\Models\User\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserMutation
{
    public function create($_, array $args)
    {
        $validator = Validator::make($args['input'], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return User::create($args['input']);
    }

    public function restore($_, array $args)
    {
        return User::withTrashed()->find($args['id'])->restore()
            ? User::find($args['id'])
            : null;
    }

    public function forceDelete($_, array $args): ?User
    {
        $user = User::withTrashed()->find($args['id']);
        if ($user) {
            $user->forceDelete();
            return $user;
        }
        return null;
    }
}