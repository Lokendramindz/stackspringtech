<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="robots" content="noindex,nofollow"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot password — Admin</title><link rel="icon" href="{{ asset('favicon.png') }}"><link rel="stylesheet" href="{{ asset('css/site.css') }}"></head>
<body><main class="wrap narrow sec"><a href="{{ route('login') }}"><img class="loginlogo" src="{{ asset('images/logo.png') }}" alt="StackSpring Technologies"></a><h1>Reset your password</h1>
<p class="sub">Enter your admin email address and we’ll send a reset link if an account matches.</p>
@if (session('status'))<div class="ok">{{ session('status') }}</div>@endif
<form method="POST" action="{{ route('password.email') }}" class="form">@csrf
  <label>Admin email<input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"></label>
  @error('email')<ul class="err"><li>{{ $message }}</li></ul>@enderror
  <button class="btn" type="submit">Email reset link</button>
</form><p><a href="{{ route('login') }}">Back to admin login</a></p></main></body></html>