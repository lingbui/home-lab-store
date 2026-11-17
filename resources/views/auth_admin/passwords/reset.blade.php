<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Đặt lại mật khẩu quản trị</title>
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
      <p class="login-box-msg" style="font-weight:600; font-size: 18px;">Đặt mật khẩu mới</p>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $email ?? old('email') }}" required>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Mật khẩu mới (tối thiểu 8 ký tự)" name="password" required>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Nhập lại mật khẩu mới" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-flat">Đặt lại mật khẩu</button>
      </form>
    </div>
  </div>
</body>
</html>

