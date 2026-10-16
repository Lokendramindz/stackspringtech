@extends('layouts.app')
@section('title', $seo->meta_title)
@section('desc', $seo->meta_description)
@section('robots', $seo->meta_robots)
@section('og_image', $seo->og_image)
@section('content')
<section class="inner-hero services-hero reveal"><div class="wrap inner-hero-grid">
  <div><p class="eyebrow">Services / Engineering</p><h1>{{ $pageCopy['content.services.hero_title'] }}</h1><p class="inner-lead">{{ $pageCopy['content.services.hero_intro'] }}</p><a class="btn" href="{{ route('contact') }}">Discuss your project <span aria-hidden="true">↗</span></a></div>
  <div class="inner-hero-note"><span>What we build</span><strong>Websites</strong><strong>E-commerce</strong><strong>Applications</strong><strong>Integrations</strong></div>
</div></section>
<section class="wrap sec service-list-section reveal"><div class="section-heading"><div><p class="eyebrow">Choose your starting point</p><h2>{{ $pageCopy['content.services.list_heading'] }}</h2></div><p class="sub">Each engagement is shaped around your requirements, timeline, and the systems you already use.</p></div>
  <div class="service-list-grid">@foreach ($services as $index => $s)
    <article class="service-list-card"><span class="service-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><p class="service-audience">{{ $s->ideal_for }}</p><h2>{{ $s->title }}</h2><p>{{ $s->summary }}</p><a class="text-link" href="{{ route('service', $s->slug) }}">Explore service <span aria-hidden="true">→</span></a></article>
  @endforeach</div>
</section>
@include('site._technologies')
<section class="inner-cta reveal"><div class="wrap inner-cta-row"><div><p class="eyebrow">Not sure which service fits?</p><h2>{{ $pageCopy['content.services.cta_heading'] }}</h2></div><a class="btn" href="{{ route('contact') }}">Talk to our team <span aria-hidden="true">↗</span></a></div></section>
@endsection
