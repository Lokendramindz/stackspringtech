<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_load(): void
    {
        $this->seed();
        foreach (['/', '/about', '/services', '/services/mobile-app-development', '/services/game-development', '/packages', '/blog', '/contact', '/sitemap.xml'] as $url) {
            $this->get($url)->assertOk();
        }
        $this->get('/services/mobile-app-development')->assertSee('Flutter')->assertSee('app-store release checklist');
        $this->get('/services/game-development')->assertSee('Unity')->assertSee('gameplay loop');
        $this->get('/packages')->assertSee('Mobile App MVP')->assertSee('Game Prototype')->assertSee('Playtest notes');
    }

    public function test_admin_requires_login_and_lead_form_saves(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->post('/contact', ['name' => 'Test', 'email' => 't@example.com', 'message' => 'Hello'])->assertRedirect(route('contact'));
        $this->assertDatabaseHas('leads', ['email' => 't@example.com']);
    }

    public function test_static_page_seo_can_be_managed_and_rendered(): void
    {
        $this->seed();
        $this->get('/')->assertOk()->assertSee('<meta name="robots" content="index,follow">', false);
        $this->actingAs(User::firstOrFail())->get('/admin/seo')->assertOk()->assertSee('Homepage')->assertSee('Social sharing image URL');

        $seo = [];
        foreach (config('stackspring.seo_pages') as $key => $page) {
            $seo[$key] = [
                'meta_title' => $key === 'home' ? 'Custom homepage title' : $page['meta_title'],
                'meta_description' => $page['meta_description'],
                'meta_robots' => $key === 'home' ? 'noindex' : 'index',
                'og_image' => '',
            ];
        }

        $this->post('/admin/seo', ['seo' => $seo])->assertRedirect(route('admin.seo'));
        $this->assertDatabaseHas('seo_settings', ['page_key' => 'home', 'meta_title' => 'Custom homepage title']);
        $this->get('/')->assertSee('<title>Custom homepage title | StackSpring Technologies</title>', false)
            ->assertSee('<meta name="robots" content="noindex,follow">', false);
    }

    public function test_admin_can_request_and_complete_a_password_reset(): void
    {
        $user = User::factory()->create(['email' => 'admin@example.com']);
        Notification::fake();

        $this->get('/admin/login')->assertOk()->assertSee('Forgot password?');
        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect()
            ->assertSessionHas('status', 'If an admin account matches that email, a password reset link has been sent.');

        $token = null;
        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use (&$token) {
            $token = $notification->token;
            return true;
        });

        $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertOk()
            ->assertSee('Choose a new password');

        $newPassword = 'NewSecurePassword2026';
        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    }

    public function test_admin_dashboard_summarizes_the_lead_pipeline(): void
    {
        $this->seed();
        $admin = User::firstOrFail();
        foreach ([['new', 'New lead'], ['proposal', 'Proposal lead']] as [$status, $name]) {
            Lead::create([
                'name' => $name,
                'email' => str_replace(' ', '.', strtolower($name)) . '@example.com',
                'message' => 'Project enquiry',
                'status' => $status,
            ]);
        }

        $this->actingAs($admin)->get(route('admin'))
            ->assertOk()
            ->assertSee('Needs attention')
            ->assertSee('In pipeline')
            ->assertSee('Last 7 days')
            ->assertSee('2 total')
            ->assertSee('Recent leads')
            ->assertSee('New lead')
            ->assertSee('Proposal lead');
    }

    public function test_admin_can_update_public_header_and_footer_settings(): void
    {
        $this->seed();
        $admin = User::firstOrFail();
        $settings = collect(config('stackspring.shell_settings'))
            ->map(fn ($field) => $field['default'])
            ->all();
        $settings['site_name'] = 'Northstar Digital';
        $settings['sales_phone'] = '+91 80000 00000';
        $settings['sales_phone_href'] = '+918000000000';
        $settings['contact_email'] = 'team@northstar.example';
        $settings['show_hr_phone'] = '0';
        $settings['show_nav_blog'] = '0';
        $settings['footer_description'] = 'A custom footer statement.';

        $this->actingAs($admin)->post(route('admin.site-settings.update'), $settings)
            ->assertRedirect(route('admin.site-settings'));

        $this->get('/')->assertOk()
            ->assertSee('Northstar Digital')
            ->assertSee('tel:+918000000000')
            ->assertDontSee('tel:+919251645283')
            ->assertSee('mailto:team@northstar.example')
            ->assertSee('A custom footer statement.')
            ->assertDontSee('Blog');
    }
}
