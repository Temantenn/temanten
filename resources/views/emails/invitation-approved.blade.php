<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Aktif</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f5f0; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #8B6F47, #C4A063); padding: 30px; text-align: center; color: #fff; }
        .header h1 { margin: 0; font-size: 24px; }
        .body { padding: 30px; }
        .body p { line-height: 1.7; margin-bottom: 16px; }
        .credentials { background: #faf7f2; border: 1px solid #e8e0d4; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .credentials h3 { margin-top: 0; color: #8B6F47; }
        .credentials .item { margin-bottom: 10px; }
        .credentials .label { font-weight: 600; color: #555; }
        .credentials .value { font-family: 'Courier New', monospace; background: #f0ebe3; padding: 4px 8px; border-radius: 4px; }
        .cta { text-align: center; margin: 25px 0; }
        .cta a { display: inline-block; background: linear-gradient(135deg, #8B6F47, #C4A063); color: #fff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; }
        .footer { text-align: center; padding: 20px; color: #999; font-size: 13px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Undangan Anda Telah Aktif!</h1>
        </div>
        <div class="body">
            <p>Halo,</p>
            <p>Kabar baik! Undangan pernikahan <strong>{{ $invitation->content['mempelai']['pria']['nama'] ?? '' }} & {{ $invitation->content['mempelai']['wanita']['nama'] ?? '' }}</strong> telah di-<strong>approve</strong> oleh admin.</p>

            <p>Berikut adalah informasi login Anda:</p>

            <div class="credentials">
                <h3>🔑 Akun Anda</h3>
                <div class="item">
                    <span class="label">Email:</span>
                    <span class="value">{{ $invitation->user->email ?? '-' }}</span>
                </div>
                <div class="item">
                    <span class="label">Password:</span>
                    <span class="value">{{ $plainPassword }}</span>
                </div>
            </div>

            <p>Anda dapat langsung login untuk mengatur undangan, menambah tamu, dan membagikan link undangan.</p>

            <div class="cta">
                <a href="{{ url('/login') }}">Login Sekarang →</a>
            </div>

            <p><small>Catatan: Simpan informasi ini dengan baik. Anda dapat mengubah password setelah login.</small></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Temanten. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>