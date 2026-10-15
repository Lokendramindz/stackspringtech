@extends('layouts.app')
@section('title', $post->meta_title ?: $post->title)
@section('desc', $post->meta_description ?: ($post->excerpt ?: Str::limit(strip_tags($post->body), 155)))
@section('og_type', 'article')
@section('content')
<article class="wrap sec narrow prose"><p class="meta">{{ $post->published_at?->format('d M Y') }}</p><h1>{{ $post->title }}</h1>
{!! Str::markdown($post->body ?? '', ['html_input' => 'strip']) !!}<p><a href="{{ route('blog') }}">← Back to blog</a></p></article>
@endsection
