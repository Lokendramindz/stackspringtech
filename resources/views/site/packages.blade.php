@extends('layouts.app')
@section('title', $seo->meta_title)
@section('desc', $seo->meta_description)
@section('robots', $seo->meta_robots)
@section('og_image', $seo->og_image)
@section('content')
<section class="inner-hero packages-hero reveal"><div class="wrap inner-hero-grid">
	<div><p class="eyebrow">Packages / A clear place to start</p><h1>{{ $pageCopy['content.packages.hero_title'] }}</h1><p class="inner-lead">{{ $pageCopy['content.packages.hero_intro'] }}</p><a class="btn" href="{{ route('contact') }}">Get a tailored estimate <span aria-hidden="true">↗</span></a></div>
	<div class="package-promise"><span>Every engagement includes</span><strong>A written scope</strong><strong>Milestones you can track</strong><strong>QA and a clean handover</strong></div>
</div></section>
<section class="wrap sec plans-section reveal"><div class="section-heading"><div><p class="eyebrow">Compare starting points</p><h2>{{ $pageCopy['content.packages.list_heading'] }}</h2></div><p class="sub">The plan names describe the work, not a one-size-fits-all feature bundle. Each scope is confirmed with you.</p></div>
	@include('site._packages', ['packages' => $packages])
</section>
<section class="package-note reveal"><div class="wrap package-note-inner"><span class="note-mark">↗</span><div><h2>Need something that doesn’t fit a package?</h2><p>We also scope custom builds, integrations, and white-label development around your existing team and stack.</p></div><a class="text-link" href="{{ route('contact') }}">Tell us what you need <span aria-hidden="true">→</span></a></div></section>
@endsection
