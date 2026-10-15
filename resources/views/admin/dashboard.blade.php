@extends('admin.layout')
@section('content')
<h1>Dashboard</h1>
<div class="grid g4">@foreach ($counts as $k => $v)<div class="card"><p class="meta">{{ $k }}</p><p class="price big">{{ $v }}</p></div>@endforeach</div>
<h2 style="margin-top:32px">Latest leads</h2>
<table class="tbl"><tr><th>Date</th><th>Name</th><th>Interest</th><th>Status</th></tr>
@foreach ($latest as $l)<tr><td>{{ $l->created_at->format('d M, H:i') }}</td><td>{{ $l->name }}<br><small>{{ $l->email }}</small></td><td>{{ $l->package ?: $l->service }}</td><td><span class="tag {{ $l->status }}">{{ $l->status }}</span></td></tr>@endforeach
</table><p><a href="{{ route('admin.leads') }}">All leads →</a></p>
@endsection
