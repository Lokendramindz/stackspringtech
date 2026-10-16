@extends('layouts.app')
@section('title', $page->meta_title ?: $page->title)
@section('desc', $page->meta_description ?: Str::limit(strip_tags($page->body), 155))
@section('robots', $page->meta_robots ?: 'index')
@section('og_image', $page->og_image)
@section('content')
<section class="inner-hero reveal"><div class="wrap inner-hero-grid"><div><p class="eyebrow">{{ config('stackspring.name') }} / {{ $page->title }}</p><h1>{{ $page->title }}</h1></div><div class="inner-hero-note"><span>Have a project in mind?</span><strong>Let's make the next step clear.</strong><a class="btn" href="{{ route('contact') }}">Talk to our team <span aria-hidden="true">↗</span></a></div></div></section>
<section class="wrap sec about-content reveal"><article class="prose">{!! Str::markdown($page->body ?? '', ['html_input' => 'strip']) !!}</article></section>
<section class="inner-cta reveal"><div class="wrap inner-cta-row"><div><p class="eyebrow">Ready when you are</p><h2>Tell us what you want to build.</h2></div><a class="btn" href="{{ route('contact') }}">Start a conversation <span aria-hidden="true">↗</span></a></div></section>
@endsection
