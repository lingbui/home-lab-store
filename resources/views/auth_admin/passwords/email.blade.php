<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quên mật khẩu quản trị</title>
  <link rel="shortcut icon" type="image" href="{{asset('images/icons/logo-store.png')}}" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-box-body">
      <p class="login-box-msg" style="font-weight:600; font-size: 18px;">Quên mật khẩu</p>

      @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <p>Nhập email tài khoản quản trị, hệ thống sẽ gửi link đặt lại mật khẩu.</p>

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group has-feedback">
          <input type="email" id="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-flat">Gửi link đặt lại mật khẩu</button>
      </form>
      <p class="mt-3" style="margin-top:15px"><a href="{{ url('admin/login') }}">Quay lại đăng nhập</a></p>
    </div>
  </div>
</body>
</html>

