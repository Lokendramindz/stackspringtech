<a class="journal-card {{ ($featured ?? false) ? 'journal-card-featured' : '' }}" href="{{ route('post', $p->slug) }}">
  <div class="journal-card-meta"><span>Field notes</span><time datetime="{{ $p->published_at?->toDateString() }}">{{ $p->published_at?->format('d M Y') }}</time></div>
  <h3>{{ $p->title }}</h3><p>{{ $p->excerpt ?: Str::limit(strip_tags($p->body), 150) }}</p>
  <span class="journal-read">{{ max(1, (int) ceil(str_word_count(strip_tags($p->body ?? '')) / 200)) }} min read <span aria-hidden="true">↗</span></span>
</a>
