<?php

namespace App\Http\Controllers\User;

use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class IndexUserController extends Controller
{
/*    public function __invoke(Request $request)
    {
        $validated = $request->validated();

        $data = new UserDTO($validated);

        return UserService::allUser($data);

    }*/
    public function __invoke(Request $request)
    {
        return UserService::allUsers();
    }
}
