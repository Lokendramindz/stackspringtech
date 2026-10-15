<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php $pageTitle = trim($__env->yieldContent('title')) ? trim($__env->yieldContent('title')) . ' | ' . config('stackspring.name') : config('stackspring.name') . ' — ' . config('stackspring.tagline'); $pageDesc = trim($__env->yieldContent('desc')) ?: config('stackspring.subtagline'); @endphp
  <title>{{ $pageTitle }}</title>
  <meta name="description" content="{{ $pageDesc }}">
  <link rel="canonical" href="{{ url()->current() }}">
  <meta property="og:site_name" content="{{ config('stackspring.name') }}">
  <meta property="og:type" content="@yield('og_type', 'website')">
  <meta property="og:title" content="{{ $pageTitle }}">
  <meta property="og:description" content="{{ $pageDesc }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ asset('images/og.png') }}">
  <meta name="twitter:card" content="summary_large_image">
  <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'Organization', 'name' => config('stackspring.name'), 'url' => url('/'), 'logo' => asset('images/logo.png'), 'email' => config('stackspring.email'), 'slogan' => config('stackspring.tagline')], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  <meta name="theme-color" content="#1a2940">
  <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
<header class="nav"><div class="wrap nav-in">
  <a class="logo" href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="StackSpring Technologies — Engineering Digital Growth"></a>
  <nav>
    <a href="{{ route('services') }}">Services</a>
    <a href="{{ route('packages') }}">Packages</a>
    <a href="{{ route('blog') }}">Blog</a>
    <a href="{{ route('about') }}">About</a>
    <a class="btn sm" href="{{ route('contact') }}">Contact</a>
  </nav>
</div></header>
<main>@yield('content')</main>
<footer><div class="wrap"><img class="flogo" src="{{ asset('images/logo-white.png') }}" alt="StackSpring Technologies"><br>© {{ date('Y') }} {{ config('stackspring.name') }} · <a href="mailto:{{ config('stackspring.email') }}">{{ config('stackspring.email') }}</a></div></footer>
</body>
</html>
