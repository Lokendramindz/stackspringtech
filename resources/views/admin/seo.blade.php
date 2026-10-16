@extends('admin.layout')
@section('content')
<h1>SEO settings</h1>
<p>Manage search and social metadata for the main public pages. Content-specific SEO is managed on each service, package, post, or page.</p>
<form method="POST" action="{{ route('admin.seo.update') }}" class="form admin-seo-form">
  @csrf
  @foreach ($pages as $key => $page)
    @php $setting = $settings->get($key); @endphp
    <fieldset class="admin-seo-page">
      <legend>{{ $page['label'] }}</legend>
      <label>Meta title<input name="seo[{{ $key }}][meta_title]" maxlength="70" value="{{ old("seo.$key.meta_title", $setting?->meta_title ?? $page['meta_title']) }}"></label>
      <label>Meta description<textarea name="seo[{{ $key }}][meta_description]" maxlength="300" rows="3">{{ old("seo.$key.meta_description", $setting?->meta_description ?? $page['meta_description']) }}</textarea></label>
      <label>Robots directive<select name="seo[{{ $key }}][meta_robots]">
        @foreach (['index' => 'Index and follow', 'noindex' => 'No index, follow links', 'none' => 'No index or follow'] as $value => $label)
          <option value="{{ $value }}" @selected(old("seo.$key.meta_robots", $setting?->meta_robots ?? 'index') === $value)>{{ $label }}</option>
        @endforeach
      </select></label>
      <label>Social sharing image URL<input type="url" name="seo[{{ $key }}][og_image]" value="{{ old("seo.$key.og_image", $setting?->og_image) }}" placeholder="https://example.com/image.jpg"></label>
    </fieldset>
  @endforeach
  @if ($errors->any())<ul class="err">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
  <button class="btn" type="submit">Save SEO settings</button>
</form>
@endsection