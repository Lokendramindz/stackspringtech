@extends('admin.layout')
@section('content')
<div class="admin-list-head"><div><p class="adm-eyebrow">Website editor</p><h1>Page content</h1><p>Update the main headings and introductions shown across the public pages.</p></div></div>
<form method="POST" action="{{ route('admin.page-content.update') }}" class="form admin-page-copy-form">@csrf
@foreach ($pages as $pageKey => $page)
  <fieldset class="admin-seo-page"><legend>{{ $page['label'] }}</legend>
  @foreach ($page['fields'] as $key => $field)<label>{{ $field['label'] }}<textarea name="content[{{ $pageKey }}][{{ $key }}]" rows="{{ str_contains($key, 'intro') ? 3 : 2 }}">{{ old("content.$pageKey.$key", $content[$pageKey][$key]) }}</textarea></label>@endforeach
  </fieldset>
@endforeach
@if ($errors->any())<ul class="err">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
<button class="btn">Save page content</button>
</form>
@endsection
