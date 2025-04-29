<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function login (LoginRequest $request)
    {
        $credentials = $request->only([
            'email',
            'password',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('Admin Access Token', ['user'])->plainTextToken;

            return response()->success([
                'user' => $user,
                'access_token' => $token,
            ]);
        }

        return response()->error('Thông tin đăng nhập không đúng.', [], 400);
    }

    public function register (RegisterRequest $request)
    {
        $data = $request->validated();

        $data['status'] = User::STATUS_REGISTER;
        $user = User::create($data);

        return response()->success();
    }

    public function logout ()
    {
        request()->user()->tokens()->delete();
        return response()->success();
    }

    public function me ()
    {
        return response()->success(request()->user());
    }
}
