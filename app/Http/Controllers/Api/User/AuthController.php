<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Mail\User\VerifyEmail;
use App\Models\User;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class AuthController extends BaseController
{
    public function login (LoginRequest $request)
    {
        $credentials = $request->only([
            'email',
            'password',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->status == User::STATUS_UNVERIFIED) {
            return response()->error('Tài khoản của bạn chưa được kích hoạt.', [], 403);
        }

        if ($user && $user->status == User::STATUS_INACTIVE) {
            return response()->error('Tài khoản của bạn đã bị vô hiệu hoá.', [], 403);
        }

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

        $user = User::where('email', $data['email'])
            ->first();

        if ($user) {
            $user->verification_token = Str::random(64);
            $user->save();
            Mail::to($user->email)->send(new VerifyEmail($user));
        } else {
            $data['status'] = User::STATUS_UNVERIFIED;
            $data['verification_token'] = Str::random(64);
            $user = User::create($data);
        }


        Mail::to($user->email)->send(new VerifyEmail($user));

        return response()->success();
    }

    public function logout ()
    {
        auth()->user()->tokens()->delete();
        return response()->success();
    }

    public function me ()
    {
        return response()->success(request()->user());
    }

    public function verify(string $token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Mã xác thực không hợp lệ hoặc đã xác thực.'], 400);
        }

        $user->email_verified_at = now();
        $user->status = User::STATUS_ACTIVE;
        $user->verification_token = null;
        $user->save();

        return response()->json(['message' => 'Xác thực email thành công.']);
    }
}
