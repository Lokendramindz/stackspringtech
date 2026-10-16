@extends('admin.layout')
@section('content')
<div class="admin-list-head"><div><p class="adm-eyebrow">Content management</p><h1>{{ $c['label'] }}</h1><p>Manage, review and update your {{ strtolower($c['label']) }}.</p></div><div class="admin-head-actions"><a class="admin-secondary-btn" href="{{ route('admin.trash', $r) }}">Trash</a><a class="btn sm" href="{{ route('admin.create', $r) }}">+ New {{ rtrim($c['label'], 's') }}</a></div></div>
<form class="admin-list-filters" method="GET"><input type="search" name="q" value="{{ request('q') }}" placeholder="Search {{ strtolower($c['label']) }}…">@if (in_array($r, ['services', 'packages', 'posts', 'pages'], true))<select name="status"><option value="">All status</option>@if (in_array($r, ['posts', 'pages'], true))<option value="published" @selected(request('status')==='published')>Published</option><option value="draft" @selected(request('status')==='draft')>Draft</option>@else<option value="active" @selected(request('status')==='active')>Active</option><option value="inactive" @selected(request('status')==='inactive')>Inactive</option>@endif</select>@endif<button class="btn sm">Filter</button><a href="{{ route('admin.index', $r) }}">Reset</a></form>
<div class="admin-table-wrap"><table class="tbl"><thead><tr>@foreach ($c['columns'] as $col)<th>{{ str_replace('_', ' ', $col) }}</th>@endforeach<th>Updated</th><th>Actions</th></tr></thead><tbody>
@foreach ($rows as $row)<tr>
  @foreach ($c['columns'] as $col)<td>@php $v = $row->$col; @endphp @if (in_array($col, ['active', 'featured']))<span class="admin-status {{ $v ? 'is-on' : 'is-off' }}">{{ $col === 'featured' ? ($v ? 'Featured' : 'Standard') : ($v ? 'Active' : 'Hidden') }}</span>@elseif ($col === 'status')<span class="admin-status {{ $v === 'published' ? 'is-on' : 'is-off' }}">{{ ucfirst($v) }}</span>@elseif ($col === 'published_at')<span class="admin-status {{ $v && $v <= now() ? 'is-on' : 'is-off' }}">{{ $v && $v <= now() ? 'Published' : 'Draft' }}</span>@else{{ is_bool($v) ? ($v ? 'Yes' : 'No') : ($v instanceof \Carbon\Carbon ? $v->format('d M Y H:i') : Str::limit((string) $v, 90)) }}@endif</td>@endforeach
  <td>{{ $row->updated_at?->format('d M Y') }}</td>
  <td><a href="{{ route('admin.edit', [$r, $row->id]) }}">Edit</a>
    <form method="POST" action="{{ route('admin.destroy', [$r, $row->id]) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="lnk danger">Delete</button></form></td>
</tr>@endforeach
</tbody></table></div>
@if ($rows->isEmpty())<div class="admin-empty-state"><strong>No {{ strtolower($c['label']) }} found</strong><span>Try changing your search or add a new item.</span></div>@endif
<div class="pager">{{ $rows->links() }}</div>
@endsection
