<div class="plan-grid">
@foreach ($packages as $p)
  @php $packageFeatures = collect($p->featureList())->merge(config('stackspring.package_points.' . $p->name, []))->filter()->unique()->values(); @endphp
  <article class="plan-card {{ $p->featured ? 'is-featured' : '' }}">
    @php
      $packageVisuals = [
        'WordPress Build' => ['https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=900&q=80', 'Developer working on a website'],
        'Shopify Store' => ['https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=900&q=80', 'Online store checkout and payment'],
        'Laravel Application' => ['https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=900&q=80', 'Application infrastructure and server lights'],
        'Care Plan' => ['https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=900&q=80', 'Circuit board for ongoing technology care'],
        'Mobile App MVP' => ['https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=80', 'Smartphone for mobile app development'],
        'Game Prototype' => ['https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=900&q=80', 'Retro gaming technology and controller'],
      ];
      [$packageImage, $packageImageAlt] = $packageVisuals[$p->name] ?? $packageVisuals['WordPress Build'];
    @endphp
    <img class="plan-image" src="{{ $packageImage }}" alt="{{ $packageImageAlt }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/og.png') }}'">
    <div class="plan-card-top"><span>{{ $p->featured ? 'Recommended starting point' : 'Project package' }}</span>@if ($p->featured)<span class="plan-badge">Featured</span>@endif</div>
    <h3>{{ $p->name }}</h3>
    <p class="plan-price">@if (config('stackspring.show_prices')){{ $p->price_label }} <small>{{ $p->period }}</small>@else<span>Scoped to your project</span>@endif</p>
    <p class="plan-description">{{ $p->description }}</p>
    <ul class="plan-features">@foreach ($packageFeatures as $f)<li><span aria-hidden="true">✓</span>{{ $f }}</li>@endforeach</ul>
    <a class="btn" href="{{ route('contact', ['package' => $p->name]) }}">Discuss this package <span aria-hidden="true">↗</span></a>
  </article>
@endforeach
</div>
