<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_load(): void
    {
        $this->seed();
        foreach (['/', '/about', '/services', '/packages', '/blog', '/contact', '/sitemap.xml'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_admin_requires_login_and_lead_form_saves(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->post('/contact', ['name' => 'Test', 'email' => 't@example.com', 'message' => 'Hello'])->assertRedirect(route('contact'));
        $this->assertDatabaseHas('leads', ['email' => 't@example.com']);
    }
}
