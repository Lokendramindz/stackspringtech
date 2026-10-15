@php $site = config('stackspring'); @endphp
@extends('layouts.app')
@section('title', 'Page not found')
@section('content')
<section class="wrap sec narrow" style="text-align:center"><h1>404 — Page not found</h1><p class="sub">The page you're looking for doesn't exist or has moved.</p>
<a class="btn" href="{{ route('home') }}">Back to home</a></section>
@endsection
