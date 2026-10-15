<?php
// Single source of truth for site content (from the Agency Launch Plan).
return [
    'name' => 'StackSpring Technologies',
    'domain' => 'stackspringtech.com',
    'email' => env('CONTACT_EMAIL', 'hello@stackspringtech.com'),
    'tagline' => 'Engineering Digital Growth.',
    'subtagline' => 'Reliable WordPress, Shopify and Laravel solutions — from custom development and API integrations to ongoing technical support.',
    'show_prices' => env('SHOW_PRICES', false), // plan prices are indicative; keep hidden until finalised

    'services' => [
        ['title' => 'WordPress / WooCommerce', 'for' => 'Digital agencies, hospitality, service businesses', 'price' => '₹30,000–₹45,000', 'text' => 'Custom themes, plugins and WooCommerce builds, delivered to a written scope.'],
        ['title' => 'Shopify Development', 'for' => 'E-commerce brands and Shopify agencies', 'price' => '₹40,000–₹70,000', 'text' => 'Theme and store customisation, apps and storefront improvements.'],
        ['title' => 'Laravel / PHP Applications', 'for' => 'SMBs, startups, operations teams', 'price' => '₹75,000+', 'text' => 'Custom web applications, booking workflows and internal tools.'],
        ['title' => 'API & Integrations', 'for' => 'Businesses with existing sites or apps', 'price' => '₹20,000–₹60,000', 'text' => 'Connect payments, CRMs, shipping and third-party platforms reliably.'],
        ['title' => 'Website Care & Maintenance', 'for' => 'Existing website owners', 'price' => '₹8,000–₹15,000 / month', 'text' => 'Updates, fixes, monitoring and ongoing technical support.'],
        ['title' => 'White-Label Support', 'for' => 'Agencies in the UK, US, Australia and UAE', 'price' => 'Scope-based retainer', 'text' => 'Dependable overflow capacity under your brand, with clear handover.'],
    ],

    'principles' => [
        ['Written scope', 'Deliverables, exclusions, milestones and change-request pricing agreed up front.'],
        ['Secure by default', 'Least-privilege access and secure credential sharing on every project.'],
        ['Clear milestones', 'Staged payments and regular updates so you always know where things stand.'],
        ['Reliable handover', 'Code review, documentation and a clean handover at the end.'],
    ],

    'steps' => [
        ['Discover', 'A short call to understand your goals, budget and timeline.'],
        ['Scope', 'A written proposal with deliverables, milestones and pricing.'],
        ['Build', 'Development with code review and QA, plus regular check-ins.'],
        ['Support', 'Handover, then optional maintenance so the site stays healthy.'],
    ],
];
