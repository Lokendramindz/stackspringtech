<?php
// Single source of truth for site content (from the Agency Launch Plan).
return [
    'name' => 'StackSpring Technologies',
    'domain' => 'stackspringtech.com',
    'email' => env('CONTACT_EMAIL', 'info@stackspringtech.com'),
    'whatsapp' => env('WHATSAPP_NUMBER', '917014648860'),
    'tagline' => 'Engineering Digital Growth.',
    'subtagline' => 'Reliable websites, online stores, mobile apps and custom software — from product planning and development to ongoing technical support.',
    'show_prices' => env('SHOW_PRICES', false), // plan prices are indicative; keep hidden until finalised

    'seo_pages' => [
        'home' => ['label' => 'Homepage', 'meta_title' => 'Web & Software Development for Growing Teams', 'meta_description' => 'StackSpring builds and supports WordPress, Shopify and Laravel products for growing businesses and digital agencies.'],
        'about' => ['label' => 'About page', 'meta_title' => 'About StackSpring Technologies', 'meta_description' => 'Meet StackSpring Technologies, a hands-on engineering partner for growing businesses and digital agencies.'],
        'ai-solutions' => ['label' => 'AI solutions', 'meta_title' => 'AI Tools & Solutions for Business', 'meta_description' => 'Explore AI assistants, development tools, creative platforms and automation products for business teams.'],
        'services' => ['label' => 'Services', 'meta_title' => 'Web Development Services', 'meta_description' => 'Explore WordPress, Shopify, Laravel, API integration, maintenance and white-label development services from StackSpring.'],
        'packages' => ['label' => 'Packages', 'meta_title' => 'Web Development Packages & Plans', 'meta_description' => 'Compare practical starting packages for WordPress, Shopify, Laravel applications and ongoing website care.'],
        'blog' => ['label' => 'Blog', 'meta_title' => 'Web Development Insights', 'meta_description' => 'Practical ideas and guidance on web development, e-commerce, integrations and ongoing website care.'],
        'contact' => ['label' => 'Contact', 'meta_title' => 'Contact StackSpring Technologies', 'meta_description' => 'Tell StackSpring about your web or software project and get a clear next step from our team.'],
    ],

    'services' => [
        ['title' => 'WordPress / WooCommerce', 'for' => 'Digital agencies, hospitality, service businesses', 'price' => 'Scope-based', 'text' => 'Custom websites and WooCommerce stores with tailored themes, product setup, integrations, performance work and handover.', 'scope' => ['Responsive pages and reusable content templates', 'WooCommerce catalogue, payment and shipping setup', 'Theme, plugin and API integration work', 'Performance, accessibility and launch QA'], 'technologies' => ['WordPress', 'WooCommerce', 'PHP', 'MySQL', 'REST APIs']],
        ['title' => 'Shopify Development', 'for' => 'E-commerce brands and Shopify agencies', 'price' => 'Scope-based', 'text' => 'Shopify storefronts, theme improvements, catalogue configuration and commerce app connections.', 'scope' => ['Theme sections and product templates', 'Navigation, collections and catalogue setup', 'Payment, shipping and app connections', 'Mobile storefront QA and launch checklist'], 'technologies' => ['Shopify', 'Liquid', 'JavaScript', 'Shopify APIs']],
        ['title' => 'Laravel / PHP Applications', 'for' => 'SMBs, startups, operations teams', 'price' => 'Scope-based', 'text' => 'Custom web applications, customer portals, booking workflows and internal operations tools.', 'scope' => ['Workflow discovery and data modelling', 'User accounts, roles and admin areas', 'Dashboards, portals and business workflows', 'API testing, documentation and handover'], 'technologies' => ['Laravel', 'PHP', 'MySQL', 'JavaScript', 'REST APIs']],
        ['title' => 'API & Integrations', 'for' => 'Businesses with existing sites or apps', 'price' => 'Scope-based', 'text' => 'Connect payments, CRMs, shipping, analytics and third-party services with dependable data flows.', 'scope' => ['API and workflow mapping', 'Webhook and authentication setup', 'Data validation, retries and error handling', 'Sandbox testing and integration notes'], 'technologies' => ['REST APIs', 'Webhooks', 'JSON', 'OAuth', 'Laravel']],
        ['title' => 'Mobile App Development', 'for' => 'Startups, customer platforms and field teams', 'price' => 'Scope-based', 'text' => 'Cross-platform iOS and Android apps connected to your product workflows and backend services.', 'scope' => ['User journeys, screen maps and MVP definition', 'Cross-platform app screens and navigation', 'API, account and notification integration', 'Device QA and app-store release checklist'], 'technologies' => ['Flutter', 'React Native', 'iOS', 'Android', 'REST APIs']],
        ['title' => 'Game Development', 'for' => 'Studios, brands and teams validating a game concept', 'price' => 'Scope-based', 'text' => 'Playable 2D and 3D prototypes, core mechanics, game UI and builds for agreed test devices.', 'scope' => ['Core gameplay loop and control prototype', '2D or 3D scenes and interaction', 'Menus, HUD and basic progression', 'Device performance checks and playtest notes'], 'technologies' => ['Unity', 'C#', 'Unreal Engine', '2D', '3D']],
        ['title' => 'Product UI / UX Design', 'for' => 'Teams shaping a website, app or software product', 'price' => 'Scope-based', 'text' => 'User flows, wireframes and interface patterns that make product requirements clear before development.', 'scope' => ['User flows and screen inventory', 'Navigation and information architecture', 'Wireframes for key journeys', 'Developer-ready design handoff'], 'technologies' => ['Figma', 'Design systems', 'Responsive UI', 'Prototyping']],
        ['title' => 'Cloud Deployment & DevOps', 'for' => 'Teams launching or stabilising web applications', 'price' => 'Scope-based', 'text' => 'Production hosting, release workflows, backups and monitoring selected for your application.', 'scope' => ['Hosting and environment review', 'Staging and production configuration', 'Repeatable deployment pipeline', 'Backups, uptime checks and recovery notes'], 'technologies' => ['Linux', 'Git', 'CI/CD', 'Cloud hosting', 'Monitoring']],
        ['title' => 'Website Care & Maintenance', 'for' => 'Existing website owners', 'price' => 'Scope-based retainer', 'text' => 'Ongoing updates, backups, monitoring, fixes and practical technical support.', 'scope' => ['Core, theme and plugin updates', 'Backup and uptime checks', 'Security and performance review', 'Small fixes and monthly work summary'], 'technologies' => ['WordPress', 'Shopify', 'Laravel', 'Monitoring', 'Backups']],
        ['title' => 'White-Label Support', 'for' => 'Digital agencies needing dependable delivery capacity', 'price' => 'Scope-based retainer', 'text' => 'Flexible development support behind your brand with clear progress updates, QA and handover.', 'scope' => ['Capacity and technical-fit review', 'Scoped delivery under your workflow', 'Regular progress updates and code review', 'QA, documentation and handover'], 'technologies' => ['WordPress', 'Shopify', 'Laravel', 'PHP', 'APIs']],
    ],

    'technology_groups' => [
        ['label' => 'Web & commerce', 'items' => ['PHP', 'Laravel', 'WordPress', 'WooCommerce', 'Shopify', 'JavaScript']],
        ['label' => 'Mobile apps', 'items' => ['Flutter', 'React Native', 'iOS', 'Android']],
        ['label' => 'Games', 'items' => ['Unity', 'C#', 'Unreal Engine', '2D & 3D']],
        ['label' => 'Data & delivery', 'items' => ['MySQL', 'REST APIs', 'Webhooks', 'Git', 'CI/CD']],
    ],

    'package_points' => [
        'WordPress Build' => ['Responsive page templates', 'Plugin and integration review', 'Basic on-page SEO setup', 'Admin walkthrough and launch checklist'],
        'Shopify Store' => ['Theme sections and key templates', 'Product and collection structure', 'Payment and shipping setup review', 'Mobile storefront QA'],
        'Laravel Application' => ['User roles and admin workflows', 'Database and API planning', 'Security and validation review', 'Staging deployment and handover'],
        'Care Plan' => ['Scheduled update window', 'Backup and uptime checks', 'Monthly issue summary', 'Priority support response'],
        'Mobile App MVP' => ['Core user journeys and screen map', 'Cross-platform app foundation', 'API and account integration', 'Device QA and release checklist'],
        'Game Prototype' => ['Playable core mechanic', '2D or 3D prototype scene', 'Basic menus and HUD', 'Build for agreed test devices', 'Playtest notes and next-phase plan'],
    ],

    'shell_settings' => [
        'site_name' => ['label' => 'Brand name', 'type' => 'text', 'default' => 'StackSpring Technologies'],
        'site_tagline' => ['label' => 'Brand tagline', 'type' => 'text', 'default' => 'Engineering Digital Growth.'],
        'header_logo' => ['label' => 'Header logo', 'type' => 'image', 'default' => 'images/logo.png'],
        'footer_logo' => ['label' => 'Footer logo', 'type' => 'image', 'default' => 'images/logo-white.png'],
        'sales_phone' => ['label' => 'Sales phone display', 'type' => 'text', 'default' => '+91 63502 20215'],
        'sales_phone_href' => ['label' => 'Sales phone link', 'type' => 'text', 'default' => '+916350220215'],
        'hr_phone' => ['label' => 'HR phone display', 'type' => 'text', 'default' => '+91 92516 45283'],
        'hr_phone_href' => ['label' => 'HR phone link', 'type' => 'text', 'default' => '+919251645283'],
        'topbar_note' => ['label' => 'Topbar note', 'type' => 'text', 'default' => 'We answer our phones!'],
        'whatsapp_number' => ['label' => 'WhatsApp number (country code + digits)', 'type' => 'text', 'default' => '917014648860'],
        'contact_email' => ['label' => 'Contact email', 'type' => 'email', 'default' => 'info@stackspringtech.com'],
        'show_sales_phone' => ['label' => 'Show sales phone', 'type' => 'checkbox', 'default' => '1'],
        'show_hr_phone' => ['label' => 'Show HR phone', 'type' => 'checkbox', 'default' => '1'],
        'show_topbar_note' => ['label' => 'Show topbar note', 'type' => 'checkbox', 'default' => '1'],
        'nav_services' => ['label' => 'Services navigation label', 'type' => 'text', 'default' => 'Services'],
        'nav_packages' => ['label' => 'Packages navigation label', 'type' => 'text', 'default' => 'Packages'],
        'nav_blog' => ['label' => 'Blog navigation label', 'type' => 'text', 'default' => 'Blog'],
        'nav_about' => ['label' => 'About navigation label', 'type' => 'text', 'default' => 'About'],
        'nav_contact' => ['label' => 'Contact navigation label', 'type' => 'text', 'default' => 'Contact'],
        'show_nav_services' => ['label' => 'Show Services link', 'type' => 'checkbox', 'default' => '1'],
        'show_nav_packages' => ['label' => 'Show Packages link', 'type' => 'checkbox', 'default' => '1'],
        'show_nav_blog' => ['label' => 'Show Blog link', 'type' => 'checkbox', 'default' => '1'],
        'show_nav_about' => ['label' => 'Show About link', 'type' => 'checkbox', 'default' => '1'],
        'footer_description' => ['label' => 'Footer description', 'type' => 'textarea', 'default' => 'Thoughtful engineering for websites, stores, apps, and software that move your business forward.'],
        'footer_explore_heading' => ['label' => 'Footer navigation heading', 'type' => 'text', 'default' => 'Explore'],
        'footer_contact_heading' => ['label' => 'Footer contact heading', 'type' => 'text', 'default' => 'Have a project in mind?'],
        'footer_contact_label' => ['label' => 'Footer contact link label', 'type' => 'text', 'default' => "Let's talk"],
        'footer_signoff' => ['label' => 'Footer sign-off', 'type' => 'text', 'default' => 'Built with care, delivered with clarity.'],
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
