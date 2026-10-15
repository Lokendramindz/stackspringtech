<a class="card link" href="{{ route('post', $p->slug) }}">
  <p class="meta">{{ $p->published_at?->format('d M Y') }}</p><h3>{{ $p->title }}</h3><p>{{ $p->excerpt }}</p>
</a>
