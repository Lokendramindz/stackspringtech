@extends('layouts.app')
@section('title', $seo->meta_title)
@section('desc', $seo->meta_description)
@section('robots', $seo->meta_robots)
@section('og_image', $seo->og_image)
@section('content')
<section class="hero reveal">
  <div class="wrap hero-grid">
    <div class="hero-copy">
      <p class="eyebrow"><span class="status-dot"></span> {{ config('stackspring.name') }} · Web &amp; software studio</p>
      <h1>{{ $pageCopy['content.home.hero_title'] }}</h1>
      <p class="lead">{{ $pageCopy['content.home.hero_intro'] }}</p>
      <div class="hero-actions">
        <a class="btn" href="{{ route('contact') }}">Tell us about your project <span aria-hidden="true">↗</span></a>
        <a class="text-link" href="{{ route('services') }}">Explore what we do <span aria-hidden="true">→</span></a>
      </div>
      <p class="hero-note">A hands-on technology partner for ambitious businesses and digital agencies.</p>
    </div>
    <div class="hero-visual">
      <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&amp;fit=crop&amp;w=1200&amp;q=85" alt="A product team collaborating around a table" fetchpriority="high">
      <div class="visual-caption"><span class="caption-mark" aria-hidden="true">S</span><span><strong>Good work, clearly delivered.</strong><small>Plan well. Build with care. Stay accountable.</small></span></div>
      <span class="visual-index" aria-hidden="true">01 / 04</span>
    </div>
  </div>
</section>

<section class="audience-strip reveal" aria-label="Who we work with"><div class="wrap audience-inner">
  <span>Made for teams that need</span><strong>Growing businesses</strong><i></i><strong>Digital agencies</strong><i></i><strong>Startup teams</strong><i></i><strong>In-house teams</strong>
</div></section>

<section class="wrap sec services-section reveal">
  <div class="section-heading"><div><p class="eyebrow">What we do</p><h2>{{ $pageCopy['content.home.services_heading'] }}</h2></div><p class="sub">Practical engineering for the platforms your business relies on, with the right support to keep them moving.</p></div>
  <div class="grid service-grid">
    @foreach ($services as $index => $s)
      <a class="service-card" href="{{ route('service', $s->slug) }}">
        <span class="service-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><span class="service-arrow" aria-hidden="true">↗</span>
        <h3>{{ $s->title }}</h3><p>{{ $s->summary }}</p><p class="meta">{{ $s->ideal_for }}</p>
      </a>
    @endforeach
  </div>
  <a class="text-link section-link" href="{{ route('services') }}">See all services <span aria-hidden="true">→</span></a>
</section>

@if ($services->isNotEmpty())
<section class="service-carousel-band reveal" aria-label="Featured services">
  <div class="wrap service-carousel" data-carousel data-autoplay="true" aria-roledescription="carousel">
    <div class="carousel-heading"><div><p class="eyebrow">A closer look</p><h2>{{ $pageCopy['content.home.featured_heading'] }}</h2></div><div class="carousel-controls">
      <button type="button" data-carousel-prev aria-label="Previous service">←</button>
      <span data-carousel-status aria-live="polite">01 / {{ str_pad(min($services->count(), 6), 2, '0', STR_PAD_LEFT) }}</span>
      <button type="button" data-carousel-next aria-label="Next service">→</button>
      <button type="button" data-carousel-toggle aria-pressed="true" aria-label="Pause automatic slides">Pause</button>
    </div></div>
    <div class="carousel-stage">
      @foreach ($services->take(6) as $service)
        <article class="carousel-slide" data-carousel-slide role="group" aria-roledescription="slide" aria-label="{{ $loop->iteration }} of {{ min($services->count(), 6) }}" @if (!$loop->first) hidden @endif>
          <span class="carousel-index">0{{ $loop->iteration }}</span>
          @php
            $serviceVisuals = [
              'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1000&q=85',
              'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1000&q=85',
              'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1000&q=85',
              'https://images.unsplash.com/photo-1551434678-e076c223a692?auto=format&fit=crop&w=1000&q=85',
              'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1000&q=85',
              'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=1000&q=85',
            ];
          @endphp
          <div class="carousel-copy"><p class="carousel-for">{{ $service->ideal_for }}</p><h3>{{ $service->title }}</h3><p>{{ $service->summary }}</p></div>
          <img class="carousel-image" src="{{ $serviceVisuals[($loop->index) % count($serviceVisuals)] }}" alt="Technology workspace illustrating {{ $service->title }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/og.png') }}'">
          <a class="btn" href="{{ route('service', $service->slug) }}">Explore this service <span aria-hidden="true">↗</span></a>
        </article>
      @endforeach
    </div>
    <div class="carousel-dots" aria-label="Choose a service slide">
      @foreach ($services->take(6) as $service)<button type="button" data-carousel-to="{{ $loop->index }}" aria-label="Show {{ $service->title }} slide" @if ($loop->first) aria-current="true" @endif></button>@endforeach
    </div>
  </div>
</section>
@endif

<section class="studio-capabilities reveal"><div class="wrap sec">
  <div class="section-heading"><div><p class="eyebrow">One partner, end to end</p><h2>Build, connect, and keep improving.</h2></div><p class="sub">The best solution is more than a launch. We help you make the right technical decisions and support the product as your needs change.</p></div>
  <div class="capability-grid">
    <article><span>01 / BUILD</span><h3>Made for your workflow</h3><p>Custom websites, stores, and internal applications shaped around how your team actually works.</p></article>
    <article><span>02 / CONNECT</span><h3>Systems that talk</h3><p>Payments, shipping, CRMs, and APIs connected with a focus on reliable data flow.</p></article>
    <article><span>03 / SUPPORT</span><h3>Better after launch</h3><p>Maintenance, fixes, and practical technical support to keep your digital tools healthy.</p></article>
  </div>
</div></section>

@include('site._technologies')

<section class="approach-section reveal"><div class="wrap sec">
  <div class="section-heading"><div><p class="eyebrow">A better way to build</p><h2>Clear from day one.<br>Reliable all the way through.</h2></div><p class="sub">No mystery process, no vague promises. Just thoughtful engineering and a team that keeps you in the loop.</p></div>
  <div class="principle-grid">
    @foreach (config('stackspring.principles') as $index => [$t, $d])
      <article class="principle"><span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><h3>{{ $t }}</h3><p>{{ $d }}</p></article>
    @endforeach
  </div>
</div></section>

<section class="wrap sec process-section reveal">
  <div class="section-heading"><div><p class="eyebrow">How we work</p><h2>A simple path from idea to launch.</h2></div><p class="sub">You always know what's happening, what's next, and who to talk to.</p></div>
  <ol class="steps">@foreach (config('stackspring.steps') as [$t, $d])<li><h3>{{ $t }}</h3><p>{{ $d }}</p></li>@endforeach</ol>
</section>

<section class="agency-section reveal"><div class="wrap agency-inner">
  <div><p class="eyebrow">For digital agencies</p><h2>Your trusted build partner, behind the scenes.</h2></div>
  <div><p>Need dependable development capacity without adding permanent headcount? We work white-label with agencies, fit into your workflow, and keep delivery clear from brief to handover.</p><a class="text-link" href="{{ route('contact') }}">Talk about a partnership <span aria-hidden="true">→</span></a></div>
</div></section>

@if ($packages->count())
<section class="wrap sec packages-section reveal">
  <div class="section-heading"><div><p class="eyebrow">Ways to get started</p><h2>A useful place to begin.</h2></div><p class="sub">Starting points for common needs. Every project is scoped in writing before work begins.</p></div>
  @include('site._packages', ['packages' => $packages])
</section>
@endif

@if ($posts->count())
<section class="insights-section reveal"><div class="wrap sec">
  <div class="section-heading"><div><p class="eyebrow">Notes from the studio</p><h2>Ideas, made practical.</h2></div><a class="text-link" href="{{ route('blog') }}">Read all articles <span aria-hidden="true">→</span></a></div>
  <div class="grid">@foreach ($posts as $p)@include('site._post', ['p' => $p])@endforeach</div>
</div></section>
@endif

<section class="cta reveal"><div class="wrap cta-inner"><div><p class="eyebrow">Let's make it happen</p><h2>{{ $pageCopy['content.home.cta_heading'] }}</h2></div><a class="btn" href="{{ route('contact') }}">Start a conversation <span aria-hidden="true">↗</span></a></div></section>
@endsection
