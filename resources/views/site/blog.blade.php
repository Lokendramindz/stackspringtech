@extends('layouts.app')
@section('title', $seo->meta_title)
@section('desc', $seo->meta_description)
@section('robots', $seo->meta_robots)
@section('og_image', $seo->og_image)
@section('content')
<section class="inner-hero blog-hero reveal"><div class="wrap inner-hero-grid"><div><p class="eyebrow">Journal / Practical ideas</p><h1>{{ $pageCopy['content.blog.hero_title'] }}</h1><p class="inner-lead">{{ $pageCopy['content.blog.hero_intro'] }}</p></div><div class="journal-index"><span>From the StackSpring team</span><strong>Build with clarity.<br>Keep improving.</strong><a class="text-link" href="#latest">Browse latest articles <span aria-hidden="true">↓</span></a></div></div></section>
<section class="wrap sec blog-list-section reveal" id="latest"><div class="section-heading"><div><p class="eyebrow">Latest articles</p><h2>{{ $pageCopy['content.blog.list_heading'] }}</h2></div></div>
  <div class="blog-grid">@forelse ($posts as $index => $p)@include('site._post', ['p' => $p, 'featured' => $index === 0])@empty<div class="empty-journal"><h2>New articles are on the way.</h2><p>In the meantime, tell us what you’re working on.</p><a class="text-link" href="{{ route('contact') }}">Talk with our team <span aria-hidden="true">→</span></a></div>@endforelse</div>
  <div class="pager">{{ $posts->links() }}</div></section>
@endsection
