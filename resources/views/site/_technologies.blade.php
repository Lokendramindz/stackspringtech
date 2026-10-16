<section class="technology-section reveal">
  <div class="wrap sec">
    <div class="section-heading"><div><p class="eyebrow">Technology stack</p><h2>Tools chosen for the job.</h2></div><p class="sub">We select technologies around the product, team, release plan and long-term support needs.</p></div>
    <div class="technology-showcase">
      <div class="technology-visual">
        <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1100&q=85" alt="Close-up of a technology circuit board" loading="lazy">
        <div class="technology-visual-caption"><span>Our toolkit</span><strong>Built around your product.</strong></div>
      </div>
      <div class="technology-groups">
      @foreach (config('stackspring.technology_groups') as $group)
        <article class="technology-group"><span class="technology-group-mark" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><h3>{{ $group['label'] }}</h3><div class="technology-list">@foreach ($group['items'] as $technology)<span>{{ $technology }}</span>@endforeach</div></article>
      @endforeach
      </div>
    </div>
  </div>
</section>
