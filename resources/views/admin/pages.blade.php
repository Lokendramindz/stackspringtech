@extends('admin.layout')
@section('content')
<div class="admin-list-head"><div><p class="adm-eyebrow">Website manager</p><h1>Pages</h1><p>Use Delete on any page row. Deleted pages can be restored from Trash.</p></div><div class="admin-head-actions"><a class="admin-secondary-btn" href="{{ route('admin.trash', 'pages') }}">Trash ({{ $trashedCount }})</a><a class="btn" href="{{ route('admin.create', 'pages') }}">+ Add page</a></div></div>
<div class="admin-table-wrap"><table class="tbl"><thead><tr><th>Page</th><th>URL</th><th>Type</th><th>Status</th><th>SEO title</th><th>Navigation</th><th>Actions</th></tr></thead><tbody>
@foreach ($pages as $key => $page)
  @php $seoKey = $key === 'ai' ? 'ai-solutions' : $key; $setting = $seo->get($seoKey); $url = $key === 'home' ? '/' : '/'.($key === 'ai' ? 'ai-solutions' : $key); @endphp
  <tr><td><strong>{{ $page['label'] }}</strong></td><td><code>{{ $url }}</code></td><td><span class="admin-status is-on">Built-in</span></td><td><span class="admin-status is-on">Published</span></td><td>{{ $setting?->meta_title ?: '—' }}</td><td>—</td><td><div class="admin-page-actions"><a class="admin-edit-btn" href="{{ route('admin.page-content.edit', $key) }}">Edit</a><form method="POST" action="{{ route('admin.page-content.delete', $key) }}" onsubmit="return confirm('Move {{ addslashes($page['label']) }} to Trash? You can restore it later.')">@csrf @method('DELETE')<button type="submit" class="admin-delete-btn">Delete</button></form></div></td></tr>
@endforeach
@foreach ($customPages as $page)
  <tr><td><strong>{{ $page->title }}</strong></td><td><code>/{{ $page->slug }}</code></td><td><span class="admin-status is-off">Custom</span></td><td><span class="admin-status {{ $page->status === 'published' ? 'is-on' : 'is-off' }}">{{ ucfirst($page->status) }}</span></td><td>{{ $page->meta_title ?: '—' }}</td><td>{{ $page->show_in_nav ? ($page->nav_label ?: $page->title) : '—' }}</td><td><div class="admin-page-actions"><a class="admin-edit-btn" href="{{ route('admin.edit', ['pages', $page->id]) }}">Edit</a><form method="POST" action="{{ route('admin.destroy', ['pages', $page->id]) }}" onsubmit="return confirm('Move this page to Trash? You can restore it later.')">@csrf @method('DELETE')<button type="submit" class="admin-delete-btn">Delete</button></form>@if ($page->status === 'published')<a class="admin-view-btn" href="{{ url('/'.$page->slug) }}" target="_blank" rel="noopener">View</a>@endif</div></td></tr>
@endforeach
</tbody></table></div>
@if ($customPages->isEmpty())<div class="admin-empty-state"><strong>No custom pages yet</strong><span>Use Add page to create a page with its own URL, content and SEO.</span></div>@endif
@endsection
