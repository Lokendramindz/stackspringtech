<?php
// Drives the generic admin CRUD: field => [input type, validation rules]
use App\Models\{Package, Page, Post, Service};

return [
    'services' => ['label' => 'Services', 'model' => Service::class, 'columns' => ['title', 'sort', 'active'], 'fields' => [
        'title' => ['text', 'required|max:150'], 'slug' => ['text', 'nullable|max:160'],
        'summary' => ['textarea', 'nullable|max:500'], 'ideal_for' => ['text', 'nullable|max:190'],
        'body' => ['textarea', 'nullable'], 'sort' => ['number', 'nullable|integer'], 'active' => ['checkbox', 'boolean'],
        'meta_title' => ['text', 'nullable|max:70'], 'meta_description' => ['textarea', 'nullable|max:300'],
    ]],
    'packages' => ['label' => 'Packages / Plans', 'model' => Package::class, 'columns' => ['name', 'price_label', 'featured', 'active'], 'fields' => [
        'name' => ['text', 'required|max:120'], 'price_label' => ['text', 'required|max:60'], 'period' => ['text', 'nullable|max:40'],
        'description' => ['textarea', 'nullable|max:500'], 'features' => ['textarea', 'nullable'],
        'sort' => ['number', 'nullable|integer'], 'featured' => ['checkbox', 'boolean'], 'active' => ['checkbox', 'boolean'],
    ]],
    'posts' => ['label' => 'Blog posts', 'model' => Post::class, 'columns' => ['title', 'published_at'], 'fields' => [
        'title' => ['text', 'required|max:180'], 'slug' => ['text', 'nullable|max:190'], 'excerpt' => ['textarea', 'nullable|max:500'],
        'body' => ['textarea', 'nullable'], 'published_at' => ['datetime-local', 'nullable|date'],
        'meta_title' => ['text', 'nullable|max:70'], 'meta_description' => ['textarea', 'nullable|max:300'],
    ]],
    'pages' => ['label' => 'Pages (About…)', 'model' => Page::class, 'columns' => ['title', 'slug'], 'fields' => [
        'title' => ['text', 'required|max:150'], 'slug' => ['text', 'nullable|max:160'], 'body' => ['textarea', 'nullable'],
        'meta_title' => ['text', 'nullable|max:70'], 'meta_description' => ['textarea', 'nullable|max:300'],
    ]],
];
