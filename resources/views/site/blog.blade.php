@extends('layouts.app')
@section('title', 'Blog')
@section('content')
<section class="wrap sec"><h1>Blog</h1>
  <div class="grid">@forelse ($posts as $p)@include('site._post', ['p' => $p])@empty<p>No posts yet.</p>@endforelse</div>
  <div class="pager">{{ $posts->links() }}</div></section>
@endsection
