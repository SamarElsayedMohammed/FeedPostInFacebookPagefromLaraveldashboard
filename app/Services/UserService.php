<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;

class UserService
{

    public function createUser(UserDTO $userDTO): User
    {
        $user = new User();
        $user->name = $userDTO->name;
        $user->email = $userDTO->email;
        $user->password = $userDTO->password;
        $user->token = $userDTO->token;
        $user->image = $userDTO->image;
        $user->provider_app_id = $userDTO->provider_app_id;
        $user->facebook_app_id = $userDTO->facebook_app_id;
        $user->provider = $userDTO->provider;
        $user->save();

        return $user;
    }

}