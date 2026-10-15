@extends('layouts.app')
@section('content')
<section class="hero"><div class="wrap">
  <p class="eyebrow">Web &amp; software development</p>
  <h1>{{ config('stackspring.tagline') }}</h1>
  <p class="lead">{{ config('stackspring.subtagline') }}</p>
  <a class="btn" href="{{ route('contact') }}">Start a project</a>
  <a class="btn ghost" href="{{ route('services') }}">Our services</a>
</div></section>

<section class="wrap sec">
  <h2>What we build</h2><p class="sub">Focused on the technologies we deliver with confidence.</p>
  <div class="grid">
    @foreach ($services as $s)
      <a class="card link" href="{{ route('service', $s->slug) }}"><h3>{{ $s->title }}</h3><p>{{ $s->summary }}</p><p class="meta">{{ $s->ideal_for }}</p></a>
    @endforeach
  </div>
</section>

<section class="alt"><div class="wrap sec">
  <h2>How we work</h2>
  <div class="grid g4">
    @foreach (config('stackspring.principles') as [$t, $d])<article class="card flat"><h3>{{ $t }}</h3><p>{{ $d }}</p></article>@endforeach
  </div>
</div></section>

<section class="wrap sec">
  <h2>Our process</h2>
  <ol class="steps">@foreach (config('stackspring.steps') as [$t, $d])<li><h3>{{ $t }}</h3><p>{{ $d }}</p></li>@endforeach</ol>
</section>

@if ($packages->count())
<section class="alt"><div class="wrap sec">
  <h2>Packages</h2><p class="sub">Starting points — every project is scoped in writing.</p>
  @include('site._packages', ['packages' => $packages])
</div></section>
@endif

@if ($posts->count())
<section class="wrap sec">
  <h2>Latest from the blog</h2>
  <div class="grid">@foreach ($posts as $p)@include('site._post', ['p' => $p])@endforeach</div>
</section>
@endif

<section class="cta"><div class="wrap"><h2>Have a project in mind?</h2><a class="btn" href="{{ route('contact') }}">Request a quote</a></div></section>
@endsection
