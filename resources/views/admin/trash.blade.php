@extends('admin.layout')
@section('content')
<div class="admin-list-head"><div><p class="adm-eyebrow">{{ $c['label'] }}</p><h1>Trash</h1><p>Deleted items are kept here and can be restored.</p></div><a class="btn sm" href="{{ route('admin.index', $r) }}">Back to {{ $c['label'] }}</a></div>
@if ($r === 'pages' && $fixedDeleted->isNotEmpty())<section class="admin-edit-section"><h2>Built-in pages</h2><div class="admin-table-wrap"><table class="tbl"><thead><tr><th>Page</th><th>Actions</th></tr></thead><tbody>@foreach ($fixedDeleted as $page)<tr><td><strong>{{ $page['label'] }}</strong></td><td><form method="POST" action="{{ route('admin.page-content.restore', $page['key']) }}">@csrf<button class="admin-revision-restore">Restore page</button></form></td></tr>@endforeach</tbody></table></div></section>@endif
@if ($rows->isNotEmpty())<div class="admin-table-wrap"><table class="tbl"><thead><tr><th>Title</th><th>Deleted</th><th>Actions</th></tr></thead><tbody>@foreach ($rows as $row)<tr><td><strong>{{ $row->title ?? $row->name }}</strong></td><td>{{ $row->deleted_at?->format('d M Y, H:i') }}</td><td><form method="POST" action="{{ route('admin.restore', [$r, $row->id]) }}">@csrf<button class="admin-revision-restore">Restore</button></form></td></tr>@endforeach</tbody></table></div>@endif
@if ($rows->isEmpty() && ($r !== 'pages' || $fixedDeleted->isEmpty()))<div class="admin-empty-state"><strong>Trash is empty</strong><span>Deleted items will appear here and can be restored.</span></div>@endif
<div class="pager">{{ $rows->links() }}</div>
@endsection
