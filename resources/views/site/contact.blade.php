@extends('layouts.app')
@section('title', $seo->meta_title)
@section('desc', $seo->meta_description)
@section('robots', $seo->meta_robots)
@section('og_image', $seo->og_image)
@section('content')
<section class="contact-page reveal"><div class="wrap sec">
  <div class="contact-intro"><p class="eyebrow">Contact / Start a conversation</p><h1>{{ $pageCopy['content.contact.hero_title'] }}</h1><p class="inner-lead">{{ $pageCopy['content.contact.hero_intro'] }}</p></div>
  <div class="contact-layout">
    <aside class="contact-aside"><span class="contact-orbit" aria-hidden="true"></span><p class="eyebrow">A good project starts here</p><h2>Clear goals.<br>Thoughtful engineering.</h2><p>Share your idea, challenge, or rough requirements. We’ll use the details to understand what kind of support fits.</p><ul><li><span>01</span> Tell us about the goal</li><li><span>02</span> Pick a service or package</li><li><span>03</span> Get the conversation started</li></ul>
      @if ($siteSettings['whatsapp_number'])<a class="btn whatsapp-inline" href="https://wa.me/{{ preg_replace('/\D+/', '', $siteSettings['whatsapp_number']) }}?text={{ urlencode('Hi ' . $siteSettings['site_name'] . ', I would like to discuss a project.') }}" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 11.8a8.4 8.4 0 0 1-12.4 7.4L3 20.5l1.3-4.9A8.4 8.4 0 1 1 20.5 11.8Z"/><path d="M8.2 7.8c.2-.4.4-.4.7-.4h.5c.2 0 .4 0 .5.4l.8 1.9c.1.3.1.5-.1.7l-.6.7c-.2.2-.2.4-.1.6.5.9 1.2 1.6 2.1 2.1.2.1.4.1.6-.1l.8-.9c.2-.2.4-.3.7-.2l1.8.9c.3.1.4.3.4.5 0 .3-.2 1.1-.7 1.5-.5.5-1.2.7-1.9.7s-1.8-.4-2.9-1c-1.5-.9-2.5-2-3.2-3.1-.6-.9-.9-1.8-.9-2.5 0-.8.4-1.4.7-1.8Z"/></svg>Chat with us on WhatsApp</a>@endif
      @if ($siteSettings['contact_email'])<a class="contact-email" href="mailto:{{ $siteSettings['contact_email'] }}">{{ $siteSettings['contact_email'] }}</a>@endif
      @if ($siteSettings['show_sales_phone'] === '1' && $siteSettings['sales_phone'])<a class="contact-email contact-phone" href="tel:{{ preg_replace('/[^\d+]/', '', $siteSettings['sales_phone_href']) }}">Call {{ $siteSettings['sales_phone'] }}</a>@endif
    </aside>
    <div class="contact-form-panel"><div class="contact-form-heading"><span>Project enquiry</span><strong>Give us a few details</strong><small>Fields marked * are required.</small></div>
      @if (session('sent'))<div class="ok">Thanks — your message has been received. We’ll be in touch soon.</div>@endif
      <form method="POST" action="{{ route('contact.send') }}" class="form">@csrf
        <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
        <div class="row"><label>Name *<input name="name" value="{{ old('name') }}" required></label><label>Email *<input type="email" name="email" value="{{ old('email') }}" required></label></div>
        <div class="row"><label>Phone<input name="phone" value="{{ old('phone') }}"></label><label>Company<input name="company" value="{{ old('company') }}"></label></div>
        <div class="row"><label>Service<select name="service"><option value="">Select…</option><option @selected(old('service', $preService) === 'AI solutions and integration')>AI solutions and integration</option>@foreach ($services as $s)<option @selected(old('service', $preService) === $s->title)>{{ $s->title }}</option>@endforeach</select></label><label>Package<select name="package"><option value="">Select…</option>@foreach ($packages as $p)<option @selected(old('package', $pre) === $p->name)>{{ $p->name }}</option>@endforeach</select></label></div>
        <label>Budget range<input name="budget" value="{{ old('budget') }}" placeholder="Optional"></label>
        <label>Project details *<textarea name="message" rows="5" placeholder="What are you looking to build or improve?" required>{{ old('message') }}</textarea></label>
        @if ($errors->any())<ul class="err">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>@endif
        <button class="btn" type="submit">Send project enquiry <span aria-hidden="true">→</span></button>
      </form>
    </div>
  </div>
</div></section>
@endsection
