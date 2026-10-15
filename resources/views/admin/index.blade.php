@extends('admin.layout')
@section('content')
<h1>{{ $c['label'] }} <a class="btn sm" href="{{ route('admin.create', $r) }}">+ New</a></h1>
<table class="tbl"><tr>@foreach ($c['columns'] as $col)<th>{{ str_replace('_', ' ', $col) }}</th>@endforeach<th></th></tr>
@foreach ($rows as $row)<tr>
  @foreach ($c['columns'] as $col)<td>@php $v = $row->$col; @endphp {{ is_bool($v) ? ($v ? 'Yes' : 'No') : ($v instanceof \Carbon\Carbon ? $v->format('d M Y H:i') : $v) }}</td>@endforeach
  <td><a href="{{ route('admin.edit', [$r, $row->id]) }}">Edit</a>
    <form method="POST" action="{{ route('admin.destroy', [$r, $row->id]) }}" style="display:inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="lnk danger">Delete</button></form></td>
</tr>@endforeach</table>
<div class="pager">{{ $rows->links() }}</div>
@endsection
