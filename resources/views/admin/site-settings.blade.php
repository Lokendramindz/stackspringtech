@extends('admin.layout')
@section('content')
<div class="admin-settings-head"><div><p class="adm-eyebrow">Site controls</p><h1>Header &amp; footer</h1><p>Changes here update the public header, top contact bar, footer and enquiry email destination.</p></div></div>
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.site-settings.update') }}" class="form site-settings-form">@csrf
  @php $section = ''; @endphp
  @foreach ($fields as $key => $field)
    @php
      $nextSection = match (true) {
          in_array($key, ['site_name', 'site_tagline', 'header_logo', 'footer_logo'], true) => 'Brand identity',
          in_array($key, ['sales_phone', 'sales_phone_href', 'hr_phone', 'hr_phone_href', 'topbar_note', 'whatsapp_number', 'contact_email', 'show_sales_phone', 'show_hr_phone', 'show_topbar_note'], true) => 'Top contact bar',
          str_starts_with($key, 'nav_') || str_starts_with($key, 'show_nav_') => 'Main navigation',
          default => 'Footer',
      };
      $value = old($key, $settings[$key] ?? $field['default']);
    @endphp
    @if ($nextSection !== $section)<h2 class="settings-section-title">{{ $nextSection }}</h2>@php $section = $nextSection; @endphp@endif
    @if ($field['type'] === 'image')
      <label class="site-image-setting">{{ $field['label'] }}
        <input type="file" name="{{ $key }}" accept="image/*">
        <small>Upload PNG, JPG or WebP image (max 4 MB).</small>
        @if ($value)<img class="site-logo-preview" src="{{ Str::startsWith($value, ['http://', 'https://']) ? $value : asset(Str::startsWith($value, 'site/') ? 'storage/'.$value : $value) }}" alt="Current {{ strtolower($field['label']) }}">@endif
      </label>
    @elseif ($field['type'] === 'checkbox')
      <label class="chk site-setting-toggle"><input type="checkbox" name="{{ $key }}" value="1" @checked((string) $value === '1')> {{ $field['label'] }}</label>
    @elseif ($field['type'] === 'textarea')
      <label>{{ $field['label'] }}<textarea name="{{ $key }}" rows="3">{{ $value }}</textarea></label>
    @else
      <label>{{ $field['label'] }}<input type="{{ $field['type'] }}" name="{{ $key }}" value="{{ $value }}"></label>
    @endif
  @endforeach
  @if ($errors->any())<ul class="err">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
  <button class="btn" type="submit">Save site details</button>
</form>
@endsection
