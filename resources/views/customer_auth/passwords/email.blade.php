@extends('layouts.master_home')

@section('title')
Quên mật khẩu - Home Lab
@endsection

@section('home')
<div class="row">
    <div class="em-col-main col-sm-24" style="margin-top : 50px; margin-bottom : 50px; max-width: 520px; margin-left:auto; margin-right:auto;">
        <h3>Quên mật khẩu</h3>
        <p>Nhập email bạn đã dùng khi đăng ký, chúng tôi sẽ gửi link đặt lại mật khẩu.</p>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('customer.password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="input-text" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <button type="submit" class="button btn-login"><span><span>Gửi link đặt lại mật khẩu</span></span></button>
        </form>
        <p style="margin-top:20px"><a href="{{ url('/login') }}" style="color: #03A9F4;">Quay lại đăng nhập</a></p>
    </div>
</div>
@endsection
