<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="robots" content="noindex,nofollow"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin — {{ config('stackspring.name') }}</title><link rel="icon" href="{{ asset('favicon.png') }}"><link rel="stylesheet" href="{{ asset('css/site.css') }}"></head>
<body class="adm">
<aside><a class="logo" href="{{ route('admin') }}"><img src="{{ asset('images/logo-white.png') }}" alt="StackSpring"><small>Admin panel</small></a>
  <a href="{{ route('admin') }}">Dashboard</a>
  <a href="{{ route('admin.leads') }}">Leads</a>
  @foreach (['services', 'packages', 'posts', 'pages'] as $k)<a href="{{ route('admin.index', $k) }}">{{ config("admin.$k.label") }}</a>@endforeach
  <a href="{{ route('home') }}" target="_blank">View site ↗</a>
  <form method="POST" action="{{ route('logout') }}">@csrf<button class="lnk">Log out</button></form>
</aside>
<section class="adm-main">
  @if (session('ok'))<div class="ok">{{ session('ok') }}</div>@endif
  @yield('content')
</section></body></html>
