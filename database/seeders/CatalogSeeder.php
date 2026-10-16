<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('stackspring.services') as $sort => $definition) {
            $service = Service::firstOrNew(['slug' => Str::slug($definition['title'])]);
            $body = $definition['text'];
            if (!empty($definition['scope'])) $body .= "\n\n## Typical project scope\n\n- " . implode("\n- ", $definition['scope']);
            if (!empty($definition['technologies'])) $body .= "\n\n## Technologies\n\n" . implode(' · ', $definition['technologies']);
            $body .= "\n\nIdeal for: " . $definition['for'];

            if (!$service->exists || str_contains((string) $service->body, 'Edit this page from the admin panel.')) {
                $service->fill([
                    'title' => $definition['title'],
                    'summary' => $definition['text'],
                    'ideal_for' => $definition['for'],
                    'sort' => $sort,
                    'active' => true,
                    'body' => $body,
                ])->save();
            }
        }

        $packages = [
            ['WordPress Build', 'From ₹30,000', null, 'Custom WordPress / WooCommerce development.', "Custom theme or plugin work\nWritten scope & milestones\nQA and handover"],
            ['Shopify Store', 'From ₹40,000', null, 'Theme and store customisation.', "Theme customisation\nStorefront improvements\nQA and handover"],
            ['Laravel Application', 'From ₹75,000', null, 'Custom web applications and integrations.', "Discovery & architecture\nBackend development\nDocumentation and handover"],
            ['Care Plan', 'From ₹8,000', 'per month', 'Ongoing website maintenance and support.', "Updates and fixes\nMonitoring\nTechnical support"],
            ['Mobile App MVP', 'Scope-based', null, 'A focused cross-platform app release that validates your core customer or team workflow.', "User journeys and screen map\nFlutter or React Native foundation\nAccounts and API connection\nPush notification setup where scoped\nDevice QA and app-store release checklist\nSource code and handover"],
            ['Game Prototype', 'Scope-based', null, 'A playable prototype to validate a 2D or 3D game mechanic before full production.', "Core gameplay loop prototype\nPlayer input and interaction\nBasic menus and HUD\nUnity or Unreal project setup\nBuild for agreed test devices\nPlaytest notes and next-phase estimate"],
        ];

        foreach ($packages as $sort => [$name, $price, $period, $description, $features]) {
            Package::firstOrCreate(['name' => $name], [
                'price_label' => $price,
                'period' => $period,
                'description' => $description,
                'features' => $features,
                'sort' => $sort,
                'featured' => $sort === 2,
                'active' => true,
            ]);
        }
    }
}