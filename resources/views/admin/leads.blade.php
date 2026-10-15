@extends('admin.layout')
@section('content')
<h1>Leads</h1>
<form method="GET" class="row filt">
  <input name="q" value="{{ request('q') }}" placeholder="Search name, email, company">
  <select name="status" onchange="this.form.submit()"><option value="">All statuses</option>@foreach ($statuses as $s)<option @selected(request('status') === $s)>{{ $s }}</option>@endforeach</select>
  <button class="btn sm">Filter</button>
</form>
@forelse ($leads as $l)
<details class="card lead"><summary><b>{{ $l->name }}</b> · {{ $l->package ?: $l->service ?: 'General' }} · <span class="tag {{ $l->status }}">{{ $l->status }}</span> <small>{{ $l->created_at->format('d M Y, H:i') }}</small></summary>
  <p><a href="mailto:{{ $l->email }}">{{ $l->email }}</a> @if($l->phone) · {{ $l->phone }} @endif @if($l->company) · {{ $l->company }} @endif @if($l->budget) · Budget: {{ $l->budget }} @endif</p>
  <p style="white-space:pre-line">{{ $l->message }}</p>
  <form method="POST" action="{{ route('admin.leads.update', $l) }}" class="form">@csrf @method('PUT')
    <div class="row"><label>Status<select name="status">@foreach ($statuses as $s)<option @selected($l->status === $s)>{{ $s }}</option>@endforeach</select></label></div>
    <label>Internal notes<textarea name="notes" rows="3">{{ $l->notes }}</textarea></label>
    <div><button class="btn sm">Save</button></div>
  </form>
  <form method="POST" action="{{ route('admin.leads.delete', $l) }}" onsubmit="return confirm('Delete this lead?')">@csrf @method('DELETE')<button class="lnk danger">Delete</button></form>
</details>
@empty<p>No leads found.</p>@endforelse
<div class="pager">{{ $leads->links() }}</div>
@endsection
