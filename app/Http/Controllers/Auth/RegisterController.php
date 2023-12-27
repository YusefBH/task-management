<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(CreateUserRequest $request)
    {
        /** @var User $user */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationNotification();
        //$token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'massage' => 'check your email for verification'
        ], 200);
    }
}
