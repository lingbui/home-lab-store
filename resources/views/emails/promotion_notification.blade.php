{{-- Dùng bởi App\Mail\SendEmail. Biến: $subject, $home, $name, $image, $logo, $link --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, Helvetica, sans-serif; color:#333;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4; padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:6px; overflow:hidden;">
                    <tr>
                        <td align="center" style="padding:24px; border-bottom:1px solid #eee;">
                            <a href="{{ $home }}" target="_blank">
                                <img src="{{ $logo }}" alt="Home Lab" style="max-height:60px; border:0;">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 32px 8px;">
                            <h2 style="margin:0 0 12px; font-size:20px; color:#222;">{{ $subject }}</h2>
                            <p style="margin:0; font-size:15px; line-height:1.6;">{{ $name }}</p>
                        </td>
                    </tr>
                    @if (!empty($image))
                    <tr>
                        <td align="center" style="padding:16px 32px;">
                            <a href="{{ $link }}" target="_blank">
                                <img src="{{ $image }}" alt="{{ $name }}" style="max-width:100%; height:auto; border:0; border-radius:4px;">
                            </a>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td align="center" style="padding:16px 32px 32px;">
                            <a href="{{ $link }}" target="_blank" style="display:inline-block; padding:12px 28px; background:#28a745; color:#ffffff; text-decoration:none; border-radius:4px; font-weight:bold;">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:16px; background:#fafafa; font-size:12px; color:#888;">
                            Bạn nhận được email này vì đã đăng ký tài khoản tại
                            <a href="{{ $home }}" style="color:#888;">{{ $home }}</a>.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
