<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin sign in | StackSpring Technologies</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <style>
        :root{color-scheme:light;--navy:#10283b;--muted:#647887;--teal:#07877c;--line:#dce7e8}
        *{box-sizing:border-box}
        body{margin:0;min-height:100vh;padding:36px 20px;display:grid;place-items:center;font:16px/1.5 'DM Sans',Arial,sans-serif;color:var(--navy);background:radial-gradient(ellipse at 12% 12%,rgba(12,176,153,.12),transparent 34%),radial-gradient(ellipse at 88% 88%,rgba(40,105,162,.10),transparent 34%),#f4f8f8}
        .auth-shell{width:min(100%,460px)}
        .brand{display:flex;justify-content:center;margin-bottom:25px}
        .brand img{display:block;width:min(250px,75%);height:76px;object-fit:contain}
        .auth-card{padding:38px 40px 32px;background:#fff;border:1px solid rgba(16,40,59,.08);border-radius:20px;box-shadow:0 24px 70px rgba(22,54,68,.12)}
        .eyebrow{margin:0 0 7px;color:var(--teal);font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
        h1{margin:0;font-size:30px;line-height:1.2;letter-spacing:-.03em;color:var(--navy)}
        .intro{margin:9px 0 27px;color:var(--muted);font-size:14px}
        .notice{margin:0 0 18px;padding:12px 14px;border-radius:10px;background:#e9f8f3;color:#08715f;font-size:14px}
        .form{display:grid;gap:18px}
        .field{display:grid;gap:7px;color:#263c4b;font-size:14px;font-weight:700}
        .field input{width:100%;height:49px;padding:0 14px;border:1px solid #cbd9dd;border-radius:10px;background:#fff;color:#10283b;font:500 15px Arial,sans-serif;outline:none;transition:border-color .18s,box-shadow .18s}
        .field input:focus{border-color:var(--teal);box-shadow:0 0 0 4px rgba(7,135,124,.12)}
        .field input:-webkit-autofill{-webkit-text-fill-color:#10283b;box-shadow:0 0 0 1000px #fff inset}
        .options{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:-2px;font-size:13px}
        .remember{display:flex;align-items:center;gap:8px;color:#526674;cursor:pointer}
        .remember input{width:16px;height:16px;margin:0;accent-color:var(--teal)}
        a{color:var(--teal);font-weight:700;text-decoration:none}a:hover{text-decoration:underline}
        .error{margin:-10px 0 0;padding:10px 12px;border-radius:9px;background:#fff1f0;color:#b42318;font-size:13px;list-style:none}
        .submit{height:50px;border:0;border-radius:10px;background:linear-gradient(100deg,#07877c,#079b8b);color:white;font:700 16px Arial,sans-serif;cursor:pointer;box-shadow:0 8px 18px rgba(7,135,124,.2);transition:transform .18s,box-shadow .18s}
        .submit:hover{transform:translateY(-1px);box-shadow:0 11px 22px rgba(7,135,124,.27)}
        .secure-note{margin:20px 0 0;text-align:center;color:#81919a;font-size:12px}
        @media(max-width:520px){body{padding:24px 16px}.auth-card{padding:30px 23px 26px;border-radius:16px}h1{font-size:27px}.brand{margin-bottom:18px}}
    </style>
</head>
<body>
    <main class="auth-shell">
        <div class="brand"><img src="{{ asset('images/logo.png') }}" alt="StackSpring Technologies"></div>
        <section class="auth-card" aria-labelledby="login-title">
            <p class="eyebrow">Website manager</p>
            <h1 id="login-title">Welcome back</h1>
            <p class="intro">Sign in to manage your website and content.</p>

            @if (session('status'))
                <div class="notice" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" class="form">
                @csrf
                <label class="field" for="email">Email address
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
                </label>
                <label class="field" for="password">Password
                    <input id="password" type="password" name="password" autocomplete="current-password" required>
                </label>
                @error('email')<ul class="error"><li>{{ $message }}</li></ul>@enderror
                @error('password')<ul class="error"><li>{{ $message }}</li></ul>@enderror
                <div class="options">
                    <label class="remember"><input type="checkbox" name="remember" value="1" @checked(old('remember'))> Remember me</label>
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </div>
                <button class="submit" type="submit">Sign in to dashboard</button>
            </form>
            <p class="secure-note">Secure administrator access</p>
        </section>
    </main>
</body>
</html>
