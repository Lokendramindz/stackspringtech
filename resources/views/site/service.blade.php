@extends('layouts.app')
@section('title', $s->meta_title ?: $s->title)
@section('desc', $s->meta_description ?: ($s->summary ?: Str::limit(strip_tags($s->body), 155)))
@section('content')
<section class="wrap sec narrow prose"><h1>{{ $s->title }}</h1>{!! Str::markdown($s->body ?? '', ['html_input' => 'strip']) !!}
<p><a class="btn" href="{{ route('contact', ['package' => $s->title]) }}">Enquire about this</a></p></section>
@endsection
