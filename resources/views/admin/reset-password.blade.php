<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="robots" content="noindex,nofollow"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Choose a new password — Admin</title><link rel="icon" href="{{ asset('favicon.png') }}"><link rel="stylesheet" href="{{ asset('css/site.css') }}"></head>
<body><main class="wrap narrow sec"><a href="{{ route('login') }}"><img class="loginlogo" src="{{ asset('images/logo.png') }}" alt="StackSpring Technologies"></a><h1>Choose a new password</h1>
<form method="POST" action="{{ route('password.update') }}" class="form">@csrf
  <input type="hidden" name="token" value="{{ $token }}">
  <label>Admin email<input type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email"></label>
  <label>New password<input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
  <label>Confirm new password<input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password"></label>
  @if ($errors->any())<ul class="err">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
  <button class="btn" type="submit">Save new password</button>
</form></main></body></html>