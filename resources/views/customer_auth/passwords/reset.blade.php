@extends('layouts.master_home')

@section('title')
Đặt lại mật khẩu - Home Lab
@endsection

@section('home')
<div class="row">
    <div class="em-col-main col-sm-24" style="margin-top : 50px; margin-bottom : 50px; max-width: 520px; margin-left:auto; margin-right:auto;">
        <h3>Đặt mật khẩu mới</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('customer.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="input-text" name="email" value="{{ $email ?? old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu mới (8-16 ký tự)</label>
                <input id="password" type="password" class="input-text" name="password" required>
            </div>
            <div class="form-group">
                <label for="password-confirm">Nhập lại mật khẩu mới</label>
                <input id="password-confirm" type="password" class="input-text" name="password_confirmation" required>
            </div>
            <button type="submit" class="button btn-login"><span><span>Đặt lại mật khẩu</span></span></button>
        </form>
    </div>
</div>
@endsection
