<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = 'customer';
    protected $table = 'customers';
    protected $fillable = [
        'name', 'birthday', 'gender', 'phone_number', 'email',
        'address', 'Số điện thoại', 'password', 'score_awards', 
        'money_payment_transactions', 'remember_token', 'status'
    ];

    /**
     * Gửi email đặt lại mật khẩu, link trỏ tới trang khách hàng (không dùng route của quản trị).
     */
    public function sendPasswordResetNotification($token)
    {
        $url = url('/reset/password/' . $token) . '?email=' . urlencode($this->email);
        $this->notify(new \App\Notifications\CustomerResetPassword($url));
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
