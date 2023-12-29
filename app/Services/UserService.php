<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserService
{
/*    public static function allUser(UserDTO $userDTO)
    {

    }*/

    public static function allUsers()
    {
        $users = User::all();
        return response()->json([
            UserResource::collection($users),
        ], 200);
    }
}
