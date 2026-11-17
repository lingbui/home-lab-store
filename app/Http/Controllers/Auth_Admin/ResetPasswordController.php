<?php

namespace App\Http\Controllers\Auth_Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Sau khi đặt lại mật khẩu, quay về trang đăng nhập quản trị.
     *
     * @var string
     */
    protected $redirectTo = '/admin/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Hiển thị form đặt mật khẩu mới (quản trị).
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth_admin.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Dùng bảng admins thay vì bảng customers mặc định.
     */
    protected function broker()
    {
        return Password::broker('admins');
    }
}
