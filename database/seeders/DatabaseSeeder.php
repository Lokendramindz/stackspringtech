<?php

namespace Database\Seeders;

use App\Models\{Page, Post, SeoSetting, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => env('ADMIN_EMAIL', 'admin@stackspringtech.com')], [
            'name' => 'Admin', 'password' => Hash::make(env('ADMIN_PASSWORD', 'ChangeMe!2026')),
        ]);

        foreach (config('stackspring.seo_pages') as $key => $seo) {
            SeoSetting::firstOrCreate(['page_key' => $key], [
                'meta_title' => $seo['meta_title'],
                'meta_description' => $seo['meta_description'],
            ]);
        }

        $this->call(CatalogSeeder::class);

        Page::firstOrCreate(['slug' => 'about'], ['title' => 'About StackSpring Technologies', 'body' =>
            "StackSpring Technologies is a web engineering and e-commerce development partner.\n\nWe help digital agencies and growing businesses ship reliable WordPress, Shopify, and Laravel solutions — from custom development and API integrations to ongoing technical support.\n\n## How we work\n\nWritten scopes, clear milestones, secure access practices and a clean handover on every project."]);

        Post::firstOrCreate(['slug' => 'welcome'], ['title' => 'Welcome to StackSpring', 'excerpt' => 'Our first post.', 'body' => 'Articles and updates will appear here. Edit or delete this post in the admin panel.', 'published_at' => now()]);
    }
}
