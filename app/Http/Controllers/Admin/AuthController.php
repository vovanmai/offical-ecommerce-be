<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function loginView ()
    {
        session(['link' => url()->previous()]);

        return view('admin.auth.login');
    }

    public function login (LoginRequest $request)
    {
        try {
            $credentials = $request->only([
                'email',
                'password',
            ]);
            $rememberMe = $request->get('remember_me', false);

            if (Auth::attempt($credentials, !!$rememberMe)) {
                $user = Auth::user();

                $user->login_at = Carbon::now();
                $user->save();
                session()->flash('success_message', 'Đăng nhập thành công!');

                // if ($link = session('link')) {
                //     $path = parse_url($link)['path'];
                //     if (str_starts_with($path, '/admin')) {
                //         return redirect($link);
                //     }
                // }
                return redirect()->route('admin.category.index');
            }
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with('error_message', 'Có một lỗi xảy ra trong lúc đăng nhập.')
                ->withInput();
        }
        return redirect()
            ->back()
            ->with('error_message', 'Thông tin đăng nhập không chính xác. Vui lòng liên hệ Super Admin để được hỗ trợ.')
            ->withInput();
    }

    public function logout ()
    {
        Auth::logout();
        session()->flash('success_message', 'Đăng xuất thành công!');
        return redirect()->route('admin.login');
    }
}
