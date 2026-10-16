@extends('admin.layout')
@section('content')
<div class="admin-list-head"><div><p class="adm-eyebrow"><a href="{{ route('admin.index', 'pages') }}">Pages</a> / Editor</p><h1>{{ $page['label'] }}</h1><p>Page copy and SEO are saved together for this page.</p></div><a class="btn sm" href="{{ route($pageKey === 'ai' ? 'ai-solutions' : ($pageKey === 'home' ? 'home' : $pageKey)) }}" target="_blank">Preview page ↗</a></div>
<form method="POST" action="{{ route('admin.page-content.update', $pageKey) }}" class="form admin-page-edit-form">@csrf @method('PUT')
<section class="admin-edit-section"><p class="adm-eyebrow">Page content</p><h2>Content for {{ $page['label'] }}</h2>
@if ($aboutPage)<label>Page title<input name="page_title" maxlength="150" value="{{ old('page_title', $aboutPage->title) }}"></label><label>About page body <small>Markdown supported</small><textarea name="page_body" rows="12">{{ old('page_body', $aboutPage->body) }}</textarea></label>@endif
@foreach ($page['fields'] as $key => $field)<label>{{ $field['label'] }}<textarea name="content[{{ $key }}]" rows="{{ str_contains($key, 'intro') ? 4 : 2 }}">{{ old("content.$key", $content[$key]) }}</textarea></label>@endforeach
</section>
<section class="admin-edit-section"><p class="adm-eyebrow">Search &amp; sharing</p><h2>SEO for {{ $page['label'] }}</h2>
<label>Meta title<input name="seo[meta_title]" maxlength="70" value="{{ old('seo.meta_title', $seo->meta_title) }}"><small>Recommended: up to 60–70 characters.</small></label>
<label>Meta description<textarea name="seo[meta_description]" maxlength="300" rows="3">{{ old('seo.meta_description', $seo->meta_description) }}</textarea></label>
<label>Robots directive<select name="seo[meta_robots]">@foreach (['index' => 'Index and follow', 'noindex' => 'No index, follow links', 'none' => 'No index or follow'] as $value => $label)<option value="{{ $value }}" @selected(old('seo.meta_robots', $seo->meta_robots) === $value)>{{ $label }}</option>@endforeach</select></label>
<label>Social sharing image URL<input type="url" name="seo[og_image]" value="{{ old('seo.og_image', $seo->og_image) }}" placeholder="https://example.com/image.jpg"></label>
</section>
@if ($errors->any())<ul class="err">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
<div class="admin-form-actions"><button class="btn">Save page and SEO</button><a href="{{ route('admin.index', 'pages') }}">Back to pages</a></div>
</form>
@if ($revisions->isNotEmpty())<section class="admin-revision-panel"><div class="admin-section-head"><div><p class="adm-eyebrow">Version history</p><h2>{{ $page['label'] }} revisions</h2></div></div><div class="admin-revision-list">@foreach ($revisions as $revision)<article><div><strong>{{ str_replace('_', ' ', ucfirst($revision->action)) }}</strong><small>{{ $revision->created_at->format('d M Y, H:i') }}</small></div><form method="POST" action="{{ route('admin.site-page-revisions.restore', [$pageKey, $revision->id]) }}" onsubmit="return confirm('Restore this saved page version?')">@csrf<button class="admin-revision-restore">Restore version</button></form></article>@endforeach</div></section>@endif
@endsection
