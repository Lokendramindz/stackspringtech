<?php

namespace Database\Seeders;

use App\Models\{Package, Page, Post, Service, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => env('ADMIN_EMAIL', 'admin@stackspringtech.com')], [
            'name' => 'Admin', 'password' => Hash::make(env('ADMIN_PASSWORD', 'ChangeMe!2026')),
        ]);

        foreach (config('stackspring.services') as $i => $s) {
            Service::firstOrCreate(['slug' => Str::slug($s['title'])], [
                'title' => $s['title'], 'summary' => $s['text'], 'ideal_for' => $s['for'], 'sort' => $i, 'active' => true,
                'body' => $s['text'] . "\n\nIdeal for: " . $s['for'] . "\n\nEdit this page from the admin panel.",
            ]);
        }

        // Indicative starting points from the launch plan — edit in admin before launch.
        $pk = [
            ['WordPress Build', 'From ₹30,000', null, 'Custom WordPress / WooCommerce development.', "Custom theme or plugin work\nWritten scope & milestones\nQA and handover"],
            ['Shopify Store', 'From ₹40,000', null, 'Theme and store customisation.', "Theme customisation\nStorefront improvements\nQA and handover"],
            ['Laravel Application', 'From ₹75,000', null, 'Custom web applications and integrations.', "Discovery & architecture\nBackend development\nDocumentation and handover"],
            ['Care Plan', 'From ₹8,000', 'per month', 'Ongoing website maintenance and support.', "Updates and fixes\nMonitoring\nTechnical support"],
        ];
        foreach ($pk as $i => [$n, $p, $per, $d, $f]) {
            Package::firstOrCreate(['name' => $n], ['price_label' => $p, 'period' => $per, 'description' => $d, 'features' => $f, 'sort' => $i, 'featured' => $i === 2, 'active' => true]);
        }

        Page::firstOrCreate(['slug' => 'about'], ['title' => 'About StackSpring Technologies', 'body' =>
            "StackSpring Technologies is a web engineering and e-commerce development partner.\n\nWe help digital agencies and growing businesses ship reliable WordPress, Shopify, and Laravel solutions — from custom development and API integrations to ongoing technical support.\n\n## How we work\n\nWritten scopes, clear milestones, secure access practices and a clean handover on every project."]);

        Post::firstOrCreate(['slug' => 'welcome'], ['title' => 'Welcome to StackSpring', 'excerpt' => 'Our first post.', 'body' => 'Articles and updates will appear here. Edit or delete this post in the admin panel.', 'published_at' => now()]);
    }
}
