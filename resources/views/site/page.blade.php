@extends('layouts.app')
@section('title', $page->meta_title ?: $page->title)
@section('desc', $page->meta_description ?: Str::limit(strip_tags($page->body), 155))
@section('content')
<section class="wrap sec narrow prose"><h1>{{ $page->title }}</h1>{!! Str::markdown($page->body ?? '', ['html_input' => 'strip']) !!}
<p><a class="btn" href="{{ route('contact') }}">Get in touch</a></p></section>
@endsection
