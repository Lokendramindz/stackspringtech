<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
    $siteSettings = \App\Models\SiteSetting::values();
    $siteName = $siteSettings['site_name'] ?: config('stackspring.name');
    $siteTagline = $siteSettings['site_tagline'] ?: config('stackspring.tagline');
    $customNavPages = \App\Models\Page::where('status', 'published')->where('show_in_nav', true)->orderBy('title')->get();
    $deletedBuiltInPages = \App\Models\SiteSetting::where('key', 'like', 'page_status.%')->where('value', 'deleted')->pluck('key')->map(fn ($key) => str_replace('page_status.', '', $key))->all();
    $headerLogo = filter_var($siteSettings['header_logo'], FILTER_VALIDATE_URL) ? $siteSettings['header_logo'] : asset(str_starts_with($siteSettings['header_logo'], 'site/') ? 'storage/' . $siteSettings['header_logo'] : $siteSettings['header_logo']);
    $footerLogo = filter_var($siteSettings['footer_logo'], FILTER_VALIDATE_URL) ? $siteSettings['footer_logo'] : asset(str_starts_with($siteSettings['footer_logo'], 'site/') ? 'storage/' . $siteSettings['footer_logo'] : $siteSettings['footer_logo']);
    $contactEmail = $siteSettings['contact_email'] ?: config('stackspring.email');
    $whatsappNumber = preg_replace('/\D+/', '', $siteSettings['whatsapp_number'] ?: config('stackspring.whatsapp'));
    $salesTel = preg_replace('/[^\d+]/', '', $siteSettings['sales_phone_href']);
    $hrTel = preg_replace('/[^\d+]/', '', $siteSettings['hr_phone_href']);
    $pageTitle = trim($__env->yieldContent('title')) ? trim($__env->yieldContent('title')) . ' | ' . $siteName : $siteName . ' — ' . $siteTagline;
    $pageDesc = trim($__env->yieldContent('desc')) ?: config('stackspring.subtagline');
    $robotsSetting = trim($__env->yieldContent('robots')) ?: 'index';
    $pageRobots = ['noindex' => 'noindex,follow', 'none' => 'noindex,nofollow'][$robotsSetting] ?? 'index,follow';
    $pageOgImage = trim($__env->yieldContent('og_image'));
    $pageOgImage = $pageOgImage ? (filter_var($pageOgImage, FILTER_VALIDATE_URL) ? $pageOgImage : asset($pageOgImage)) : asset('images/og.png');
  @endphp
  <title>{{ $pageTitle }}</title>
  <meta name="description" content="{{ $pageDesc }}">
  <meta name="robots" content="{{ $pageRobots }}">
  <link rel="canonical" href="{{ url()->current() }}">
  <meta property="og:site_name" content="{{ $siteName }}">
  <meta property="og:type" content="@yield('og_type', 'website')">
  <meta property="og:title" content="{{ $pageTitle }}">
  <meta property="og:description" content="{{ $pageDesc }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:image" content="{{ $pageOgImage }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $pageTitle }}">
  <meta name="twitter:description" content="{{ $pageDesc }}">
  <meta name="twitter:image" content="{{ $pageOgImage }}">
  <script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'Organization', 'name' => $siteName, 'url' => url('/'), 'logo' => $headerLogo, 'email' => $contactEmail, 'slogan' => $siteTagline], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
  @stack('head')
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  <meta name="theme-color" content="#07877c">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ filemtime(public_path('css/site.css')) }}">
  <link rel="stylesheet" href="{{ asset('css/site-brand.css') }}?v={{ filemtime(public_path('css/site-brand.css')) }}">
</head>
<body class="public-site">
<header class="site-header">
  <div class="topbar"><div class="wrap topbar-inner">
    <div class="topbar-contacts">
      @if ($siteSettings['show_sales_phone'] === '1')<a class="topbar-phone" href="tel:{{ $salesTel }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.6 3.5 9 3l2 4.5-2 1.7a14 14 0 0 0 5.8 5.8l1.7-2 4.5 2-.5 2.4a3 3 0 0 1-3 2.4A15.5 15.5 0 0 1 4.2 6.5a3 3 0 0 1 2.4-3Z"/></svg><span>{{ $siteSettings['sales_phone'] }} <small>Sales</small></span></a>@endif
      @if ($siteSettings['show_sales_phone'] === '1' && $siteSettings['show_hr_phone'] === '1')<span class="topbar-divider" aria-hidden="true"></span>@endif
      @if ($siteSettings['show_hr_phone'] === '1')<a class="topbar-phone topbar-hr" href="tel:{{ $hrTel }}"><span>{{ $siteSettings['hr_phone'] }} <small>HR</small></span></a>@endif
      @if ($siteSettings['show_topbar_note'] === '1' && $siteSettings['topbar_note'])<span class="topbar-promise">{{ $siteSettings['topbar_note'] }}</span>@endif
    </div>
    <div class="topbar-actions">
      @if ($whatsappNumber)<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp {{ $siteName }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.5l1.3-4.9A8.4 8.4 0 1 1 20.5 11.8Z"/><path d="M8.2 7.8c.2-.4.4-.4.7-.4h.5c.2 0 .4 0 .5.4l.8 1.9c.1.3.1.5-.1.7l-.6.7c-.2.2-.2.4-.1.6.5.9 1.2 1.6 2.1 2.1.2.1.4.1.6-.1l.8-.9c.2-.2.4-.3.7-.2l1.8.9c.3.1.4.3.4.5 0 .3-.2 1.1-.7 1.5-.5.5-1.2.7-1.9.7s-1.8-.4-2.9-1c-1.5-.9-2.5-2-3.2-3.1-.6-.9-.9-1.8-.9-2.5 0-.8.4-1.4.7-1.8Z"/></svg><span>WhatsApp</span></a>@endif
      @if ($whatsappNumber && $contactEmail)<span class="topbar-divider" aria-hidden="true"></span>@endif
      @if ($contactEmail)<a href="mailto:{{ $contactEmail }}" aria-label="Email {{ $siteName }}"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="1"/><path d="m4 7 8 6 8-6"/></svg><span>Email</span></a>@endif
    </div>
  </div></div>
  <div class="nav"><div class="wrap nav-in">
    <a class="logo" href="{{ route('home') }}"><img src="{{ $headerLogo }}" alt="{{ $siteName }} — {{ $siteTagline }}"></a>
    <nav aria-label="Main navigation">
      @if ($siteSettings['show_nav_services'] === '1' && !in_array('services', $deletedBuiltInPages, true))<a href="{{ route('services') }}">{{ $siteSettings['nav_services'] }}</a>@endif
      @if (!in_array('ai', $deletedBuiltInPages, true))<a href="{{ route('ai-solutions') }}">AI Solutions</a>@endif
      @if ($siteSettings['show_nav_packages'] === '1' && !in_array('packages', $deletedBuiltInPages, true))<a href="{{ route('packages') }}">{{ $siteSettings['nav_packages'] }}</a>@endif
      @if ($siteSettings['show_nav_blog'] === '1' && !in_array('blog', $deletedBuiltInPages, true))<a href="{{ route('blog') }}">{{ $siteSettings['nav_blog'] }}</a>@endif
      @if ($siteSettings['show_nav_about'] === '1' && !in_array('about', $deletedBuiltInPages, true))<a href="{{ route('about') }}">{{ $siteSettings['nav_about'] }}</a>@endif
      @foreach ($customNavPages as $customNavPage)<a href="{{ url('/'.$customNavPage->slug) }}">{{ $customNavPage->nav_label ?: $customNavPage->title }}</a>@endforeach
      <a class="btn sm header-contact" href="{{ route('contact') }}">{{ $siteSettings['nav_contact'] }} <span aria-hidden="true">↗</span></a>
    </nav>
  </div></div>
</header>
<main>@yield('content')</main>
<footer><div class="wrap footer-grid">
  <div class="footer-brand"><a href="{{ route('home') }}"><img class="flogo" src="{{ $footerLogo }}" alt="{{ $siteName }}"></a><p>{{ $siteSettings['footer_description'] }}</p></div>
  <div class="footer-links"><strong>{{ $siteSettings['footer_explore_heading'] }}</strong>@if ($siteSettings['show_nav_services'] === '1' && !in_array('services', $deletedBuiltInPages, true))<a href="{{ route('services') }}">{{ $siteSettings['nav_services'] }}</a>@endif @if (!in_array('ai', $deletedBuiltInPages, true))<a href="{{ route('ai-solutions') }}">AI Solutions</a>@endif @if ($siteSettings['show_nav_packages'] === '1' && !in_array('packages', $deletedBuiltInPages, true))<a href="{{ route('packages') }}">{{ $siteSettings['nav_packages'] }}</a>@endif @if ($siteSettings['show_nav_about'] === '1' && !in_array('about', $deletedBuiltInPages, true))<a href="{{ route('about') }}">{{ $siteSettings['nav_about'] }}</a>@endif @if ($siteSettings['show_nav_blog'] === '1' && !in_array('blog', $deletedBuiltInPages, true))<a href="{{ route('blog') }}">{{ $siteSettings['nav_blog'] }}</a>@endif @foreach ($customNavPages as $customNavPage)<a href="{{ url('/'.$customNavPage->slug) }}">{{ $customNavPage->nav_label ?: $customNavPage->title }}</a>@endforeach</div>
  <div class="footer-contact"><strong>{{ $siteSettings['footer_contact_heading'] }}</strong><a href="{{ route('contact') }}">{{ $siteSettings['footer_contact_label'] }} <span aria-hidden="true">↗</span></a>@if ($contactEmail)<a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>@endif</div>
  <div class="footer-bottom"><span>© {{ date('Y') }} {{ $siteName }}</span><span>{{ $siteSettings['footer_signoff'] }}</span></div>
</div></footer>
@if ($whatsappNumber)<a class="whatsapp-float" href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Hi ' . $siteName . ', I would like to discuss a project.') }}" target="_blank" rel="noopener noreferrer" aria-label="Chat with {{ $siteName }} on WhatsApp" title="Chat on WhatsApp">
  <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.5l1.3-4.9A8.4 8.4 0 1 1 20.5 11.8Z"/><path d="M8.2 7.8c.2-.4.4-.4.7-.4h.5c.2 0 .4 0 .5.4l.8 1.9c.1.3.1.5-.1.7l-.6.7c-.2.2-.2.4-.1.6.5.9 1.2 1.6 2.1 2.1.2.1.4.1.6-.1l.8-.9c.2-.2.4-.3.7-.2l1.8.9c.3.1.4.3.4.5 0 .3-.2 1.1-.7 1.5-.5.5-1.2.7-1.9.7s-1.8-.4-2.9-1c-1.5-.9-2.5-2-3.2-3.1-.6-.9-.9-1.8-.9-2.5 0-.8.4-1.4.7-1.8Z"/></svg>
  <span>WhatsApp</span>
</a>
@endif
<script src="{{ asset('js/site.js') }}" defer></script>
</body>
</html>
