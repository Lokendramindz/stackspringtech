<div class="grid">
@foreach ($packages as $p)
  <article class="card {{ $p->featured ? 'feat' : '' }}">
    <h3>{{ $p->name }}</h3>
    <p class="price big">{{ $p->price_label }} <small>{{ $p->period }}</small></p>
    <p>{{ $p->description }}</p>
    <ul class="ticks">@foreach ($p->featureList() as $f)<li>{{ $f }}</li>@endforeach</ul>
    <a class="btn sm" href="{{ route('contact', ['package' => $p->name]) }}">Choose this</a>
  </article>
@endforeach
</div>
