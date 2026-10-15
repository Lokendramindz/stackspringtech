@extends('layouts.app')
@section('title', 'Packages & Plans')
@section('content')
<section class="wrap sec"><h1>Packages &amp; plans</h1><p class="sub">Indicative starting points. Final pricing depends on scope, complexity and timeline.</p>
@include('site._packages', ['packages' => $packages])</section>
@endsection
