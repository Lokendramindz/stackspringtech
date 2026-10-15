@extends('admin.layout')
@section('content')
<h1>{{ $item ? 'Edit' : 'New' }} — {{ $c['label'] }}</h1>
<form method="POST" class="form" action="{{ $item ? route('admin.update', [$r, $item->id]) : route('admin.store', $r) }}">@csrf @if($item) @method('PUT') @endif
@foreach ($c['fields'] as $k => [$type])
  @php $val = old($k, $item ? ($type === 'datetime-local' ? $item->$k?->format('Y-m-d\TH:i') : $item->$k) : ($type === 'checkbox' ? true : '')); @endphp
  @if ($type === 'checkbox')<label class="chk"><input type="checkbox" name="{{ $k }}" value="1" @checked($val)> {{ ucfirst(str_replace('_', ' ', $k)) }}</label>
  @elseif ($type === 'textarea')<label>{{ ucfirst(str_replace('_', ' ', $k)) }}@if($k==='body' || $k==='features')<small> ({{ $k==='body' ? 'Markdown supported' : 'one per line' }})</small>@endif<textarea name="{{ $k }}" rows="{{ $k === 'body' ? 14 : 4 }}">{{ $val }}</textarea></label>
  @else<label>{{ ucfirst(str_replace('_', ' ', $k)) }}<input type="{{ $type }}" name="{{ $k }}" value="{{ $val }}"></label>@endif
@endforeach
@if ($errors->any())<ul class="err">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>@endif
<div><button class="btn">Save</button> <a href="{{ route('admin.index', $r) }}">Cancel</a></div>
</form>
@endsection
