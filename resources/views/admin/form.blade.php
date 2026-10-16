@extends('admin.layout')
@section('content')
<h1>{{ $item ? 'Edit' : 'New' }} — {{ $c['label'] }}</h1>
<form method="POST" class="form" action="{{ $item ? route('admin.update', [$r, $item->id]) : route('admin.store', $r) }}">@csrf @if($item) @method('PUT') @endif
@foreach ($c['fields'] as $k => [$type])
  @php $val = old($k, $item ? ($type === 'datetime-local' ? $item->$k?->format('Y-m-d\TH:i') : $item->$k) : ($type === 'checkbox' ? ($k === 'show_in_nav' ? false : true) : ($type === 'select' ? 'index' : ($type === 'publish-status' ? 'draft' : '')))); @endphp
  @if ($k === 'meta_title')<h2 class="admin-section-title">Search and social preview</h2>@endif
  @if ($type === 'checkbox')<label class="chk"><input type="checkbox" name="{{ $k }}" value="1" @checked($val)> {{ ucfirst(str_replace('_', ' ', $k)) }}</label>
  @elseif ($type === 'select')<label>{{ ucfirst(str_replace('_', ' ', $k)) }}<select name="{{ $k }}"><option value="index" @selected($val === 'index')>Index and follow</option><option value="noindex" @selected($val === 'noindex')>No index, follow links</option><option value="none" @selected($val === 'none')>No index or follow</option></select></label>
  @elseif ($type === 'publish-status')<label>Publication status<select name="{{ $k }}"><option value="draft" @selected($val === 'draft')>Draft</option><option value="published" @selected($val === 'published')>Published</option></select></label>
  @elseif ($type === 'textarea')<label>{{ ucfirst(str_replace('_', ' ', $k)) }}@if($k==='body' || $k==='features')<small> ({{ $k==='body' ? 'Markdown supported' : 'one per line' }})</small>@endif<textarea name="{{ $k }}" rows="{{ $k === 'body' ? 14 : 4 }}">{{ $val }}</textarea></label>
  @else<label>{{ ucfirst(str_replace('_', ' ', $k)) }}<input type="{{ $type }}" name="{{ $k }}" value="{{ $val }}"></label>@endif
@endforeach
@if ($errors->any())<ul class="err">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>@endif
<div><button class="btn">Save</button> <a href="{{ route('admin.index', $r) }}">Cancel</a></div>
</form>
@if ($item && $revisions->isNotEmpty())
<section class="admin-revision-panel"><div class="admin-section-head"><div><p class="adm-eyebrow">Version history</p><h2>Revisions for {{ $item->title ?? $item->name }}</h2></div></div>
<div class="admin-revision-list">@foreach ($revisions as $revision)<article><div><strong>{{ str_replace('_', ' ', ucfirst($revision->action)) }}</strong><small>{{ $revision->created_at->format('d M Y, H:i') }}</small></div><form method="POST" action="{{ route('admin.revisions.restore', [$r, $item->id, $revision->id]) }}" onsubmit="return confirm('Restore this saved version?')">@csrf<button class="admin-revision-restore">Restore version</button></form></article>@endforeach</div>
</section>
@endif
@endsection
