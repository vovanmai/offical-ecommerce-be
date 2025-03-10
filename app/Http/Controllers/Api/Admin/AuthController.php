<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function login (LoginRequest $request)
    {
        $credentials = $request->only([
            'email',
            'password',
        ]);

        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            $token = $admin->createToken('Admin Access Token', ['admin'])->plainTextToken;

            return response()->success([
                'admin' => $admin,
                'access_token' => $token,
            ]);
        }

        return response()->error('Thông tin đăng nhập không đúng.', [], 400);
    }

    public function logout ()
    {
        request()->user()->tokens()->delete();
        return response()->success();
    }
}
