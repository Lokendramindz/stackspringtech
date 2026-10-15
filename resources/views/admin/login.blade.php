<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="robots" content="noindex,nofollow"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin login</title><link rel="icon" href="{{ asset('favicon.png') }}"><link rel="stylesheet" href="{{ asset('css/site.css') }}"></head>
<body><div class="wrap narrow sec"><img class="loginlogo" src="{{ asset('images/logo.png') }}" alt="StackSpring Technologies"><h1>Admin login</h1>
<form method="POST" class="form">@csrf
  <label>Email<input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
  <label>Password<input type="password" name="password" required></label>
  <label class="chk"><input type="checkbox" name="remember"> Remember me</label>
  @error('email')<ul class="err"><li>{{ $message }}</li></ul>@enderror
  <button class="btn">Log in</button>
</form></div></body></html>
