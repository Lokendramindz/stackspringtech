@extends('layouts.app')
@section('title', $post->meta_title ?: $post->title)
@section('desc', $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->body), 155)))
@section('robots', $post->meta_robots ?: 'index,follow')
@section('og_image', $post->og_image)
@section('og_type', 'article')
@section('content')
@push('head')<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'BlogPosting', 'headline' => $post->title, 'description' => $post->meta_description ?: $post->excerpt, 'datePublished' => $post->published_at?->toAtomString(), 'mainEntityOfPage' => route('post', $post->slug), 'publisher' => ['@type' => 'Organization', 'name' => config('stackspring.name')]], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>@endpush
<section class="article-hero reveal"><div class="wrap"><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><a href="{{ route('blog') }}">Journal</a></nav><p class="eyebrow">Field notes <span aria-hidden="true">/</span> {{ $post->published_at?->format('d M Y') }}</p><h1>{{ $post->title }}</h1>@if ($post->excerpt)<p class="inner-lead">{{ $post->excerpt }}</p>@endif</div></section>
<article class="wrap sec article-layout reveal"><div class="prose">{!! Str::markdown($post->body ?? '', ['html_input' => 'strip']) !!}<a class="text-link" href="{{ route('blog') }}">Back to all articles <span aria-hidden="true">→</span></a></div><aside class="article-sidebar"><p class="eyebrow">Need a technical partner?</p><h2>Let’s talk through your next step.</h2><a class="btn" href="{{ route('contact') }}">Start a conversation <span aria-hidden="true">↗</span></a></aside></article>
@if ($related->isNotEmpty())<section class="related-section reveal"><div class="wrap sec"><div class="section-heading"><div><p class="eyebrow">More from the journal</p><h2>Keep reading</h2></div></div><div class="blog-grid">@foreach ($related as $p)@include('site._post', ['p' => $p])@endforeach</div></div></section>@endif
@endsection
