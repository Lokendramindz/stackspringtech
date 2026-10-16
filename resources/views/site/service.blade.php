@extends('layouts.app')
@section('title', $s->meta_title ?: $s->title)
@section('desc', $s->meta_description ?: ($s->summary ?: Str::limit(strip_tags($s->body), 155)))
@section('robots', $s->meta_robots ?: 'index,follow')
@section('og_image', $s->og_image)
@section('content')
<section class="detail-hero service-detail-hero reveal"><div class="wrap">
	<nav class="breadcrumbs" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><a href="{{ route('services') }}">Services</a><span>/</span><span>{{ $s->title }}</span></nav>
	<div class="detail-hero-grid"><div><p class="eyebrow">Service / {{ $s->ideal_for ?: 'Web engineering' }}</p><h1>{{ $s->title }}</h1><p class="inner-lead">{{ $s->summary }}</p><div class="hero-actions"><a class="btn" href="{{ route('contact', ['service' => $s->title]) }}">Plan this project <span aria-hidden="true">↗</span></a><a class="text-link" href="#service-details">See how we work <span aria-hidden="true">↓</span></a></div></div>
		<aside class="detail-snapshot"><span>What you can expect</span><strong>A written scope</strong><strong>Clear milestones</strong><strong>Tested delivery</strong><strong>Documented handover</strong></aside></div>
</div></section>
<section class="wrap sec service-detail-content reveal" id="service-details"><article class="prose">{!! Str::markdown($s->body ?? '', ['html_input' => 'strip']) !!}</article><aside class="service-enquiry"><p class="eyebrow">Ready when you are</p><h2>Let’s make this work for your team.</h2><p>Share a little about your goals, requirements, and timeline. We’ll come back with clear next steps.</p><a class="btn" href="{{ route('contact', ['service' => $s->title]) }}">Enquire about this service <span aria-hidden="true">↗</span></a></aside></section>
@if ($relatedServices->isNotEmpty())<section class="related-section reveal"><div class="wrap sec"><div class="section-heading"><div><p class="eyebrow">Keep exploring</p><h2>Related services</h2></div><a class="text-link" href="{{ route('services') }}">All services <span aria-hidden="true">→</span></a></div><div class="service-list-grid">@foreach ($relatedServices as $related)<a class="service-list-card related-service-card" href="{{ route('service', $related->slug) }}"><span class="service-audience">{{ $related->ideal_for }}</span><h3>{{ $related->title }}</h3><p>{{ $related->summary }}</p><span class="text-link">Explore <span aria-hidden="true">→</span></span></a>@endforeach</div></div></section>@endif
@endsection
