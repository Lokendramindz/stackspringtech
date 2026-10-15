@extends('layouts.app')
@section('title', 'Contact')
@section('content')
<section class="wrap sec narrow"><h1>Contact us</h1><p class="sub">Tell us about your project and we'll reply with next steps.</p>
@if (session('sent'))<div class="ok">Thanks — your message has been received. We'll be in touch soon.</div>@endif
<form method="POST" action="{{ route('contact.send') }}" class="form">@csrf
  <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
  <div class="row"><label>Name *<input name="name" value="{{ old('name') }}" required></label>
    <label>Email *<input type="email" name="email" value="{{ old('email') }}" required></label></div>
  <div class="row"><label>Phone<input name="phone" value="{{ old('phone') }}"></label>
    <label>Company<input name="company" value="{{ old('company') }}"></label></div>
  <div class="row"><label>Service<select name="service"><option value="">Select…</option>
      @foreach ($services as $s)<option @selected(old('service', $pre) === $s->title)>{{ $s->title }}</option>@endforeach</select></label>
    <label>Package<select name="package"><option value="">Select…</option>
      @foreach ($packages as $p)<option @selected(old('package', $pre) === $p->name)>{{ $p->name }}</option>@endforeach</select></label></div>
  <label>Budget range<input name="budget" value="{{ old('budget') }}" placeholder="Optional"></label>
  <label>Project details *<textarea name="message" rows="5" required>{{ old('message') }}</textarea></label>
  @if ($errors->any())<ul class="err">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>@endif
  <button class="btn" type="submit">Send enquiry</button>
</form></section>
@endsection
