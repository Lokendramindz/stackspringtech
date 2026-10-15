@extends('layouts.app')
@section('title', 'Services')
@section('content')
<section class="wrap sec"><h1>Services</h1>
  <div class="grid">@foreach ($services as $s)
    <a class="card link" href="{{ route('service', $s->slug) }}"><h3>{{ $s->title }}</h3><p>{{ $s->summary }}</p><p class="meta">{{ $s->ideal_for }}</p></a>
  @endforeach</div></section>
@endsection
