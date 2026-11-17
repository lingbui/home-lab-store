<?php

namespace App\Http\Controllers\Auth_Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Hiển thị form nhập email để nhận link đặt lại mật khẩu (quản trị).
     */
    public function showLinkRequestForm()
    {
        return view('auth_admin.passwords.email');
    }

    /**
     * Dùng bảng admins thay vì bảng customers mặc định.
     */
    protected function broker()
    {
        return Password::broker('admins');
    }
}
