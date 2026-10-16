<?php

namespace App\Http\Controllers;

use App\Models\{Lead, Package, Page, Post, SeoSetting, Service, SiteSetting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    private function activeServices() { return Service::where('active', true)->orderBy('sort')->get(); }

    private function ensureBuiltInPageIsPublished(string $key): void
    {
        abort_if(SiteSetting::where('key', "page_status.$key")->value('value') === 'deleted', 404);
    }

    public function home()
    {
        $this->ensureBuiltInPageIsPublished('home');
        return view('site.home', [
            'services' => $this->activeServices(),
            'packages' => Package::where('active', true)->orderBy('sort')->get(),
            'posts' => Post::where('published_at', '<=', now())->latest('published_at')->take(3)->get(),
            'seo' => SeoSetting::forPage('home'),
        ]);
    }

    public function about() { $this->ensureBuiltInPageIsPublished('about'); return view('site.page', ['page' => Page::where('slug', 'about')->firstOrFail(), 'seo' => SeoSetting::forPage('about')]); }
    public function customPage(string $slug) { return view('site.custom-page', ['page' => Page::where('slug', $slug)->where('slug', '!=', 'about')->where('status', 'published')->firstOrFail()]); }
    public function aiSolutions() { $this->ensureBuiltInPageIsPublished('ai'); return view('site.ai-solutions', ['seo' => SeoSetting::forPage('ai-solutions')]); }
    public function services() { $this->ensureBuiltInPageIsPublished('services'); return view('site.services', ['services' => $this->activeServices(), 'seo' => SeoSetting::forPage('services')]); }

    public function packages() { $this->ensureBuiltInPageIsPublished('packages'); return view('site.packages', ['packages' => Package::where('active', true)->orderBy('sort')->get(), 'seo' => SeoSetting::forPage('packages')]); }

    public function blog() { $this->ensureBuiltInPageIsPublished('blog'); return view('site.blog', ['posts' => Post::where('published_at', '<=', now())->latest('published_at')->paginate(9), 'seo' => SeoSetting::forPage('blog')]); }

    public function post(string $slug)
    {
        $post = Post::where('slug', $slug)->where('published_at', '<=', now())->firstOrFail();
        return view('site.post', ['post' => $post, 'related' => Post::where('published_at', '<=', now())->whereKeyNot($post->id)->latest('published_at')->take(3)->get()]);
    }

    public function service(string $slug)
    {
        $service = Service::where('slug', $slug)->where('active', true)->firstOrFail();
        return view('site.service', [
            's' => $service,
            'relatedServices' => Service::where('active', true)->whereKeyNot($service->id)->orderBy('sort')->take(3)->get(),
        ]);
    }

    public function contact(Request $r)
    {
        $this->ensureBuiltInPageIsPublished('contact');
        return view('site.contact', [
            'services' => $this->activeServices(),
            'packages' => Package::where('active', true)->orderBy('sort')->get(),
            'pre' => $r->query('package'),
            'preService' => $r->query('service'),
            'seo' => SeoSetting::forPage('contact'),
            'siteSettings' => SiteSetting::values(),
        ]);
    }

    public function sitemap()
    {
        $urls = collect(['home' => 'home', 'about' => 'about', 'ai-solutions' => 'ai', 'services' => 'services', 'packages' => 'packages', 'blog' => 'blog', 'contact' => 'contact'])
            ->filter(fn ($key) => SiteSetting::where('key', "page_status.$key")->value('value') !== 'deleted')
            ->map(fn ($key, $routeName) => ['loc' => route($routeName), 'lastmod' => null])->values();
        foreach (Service::where('active', true)->get() as $x) $urls->push(['loc' => route('service', $x->slug), 'lastmod' => $x->updated_at]);
        foreach (Post::where('published_at', '<=', now())->get() as $x) $urls->push(['loc' => route('post', $x->slug), 'lastmod' => $x->updated_at]);
        foreach (Page::whereNotIn('slug', ['home', 'about', 'ai-solutions', 'services', 'packages', 'blog', 'contact'])->where('status', 'published')->where('meta_robots', 'index')->get() as $x) $urls->push(['loc' => url('/'.$x->slug), 'lastmod' => $x->updated_at]);
        return response()->view('sitemap', ['urls' => $urls])->header('Content-Type', 'application/xml');
    }

    public function send(Request $request)
    {
        if ($request->filled('website')) return redirect()->route('contact')->with('sent', true); // honeypot

        $data = $request->validate([
            'name' => 'required|string|max:120', 'email' => 'required|email|max:190',
            'phone' => 'nullable|string|max:40', 'company' => 'nullable|string|max:150',
            'service' => 'nullable|string|max:150', 'package' => 'nullable|string|max:120',
            'budget' => 'nullable|string|max:60', 'message' => 'required|string|max:3000',
        ]);
        $lead = Lead::create($data);

        try {
            $contactEmail = SiteSetting::values()['contact_email'] ?: config('stackspring.email');
            Mail::raw("New lead #{$lead->id}\n\n" . collect($data)->map(fn ($v, $k) => ucfirst($k) . ': ' . $v)->implode("\n"),
                fn ($m) => $m->to($contactEmail)->replyTo($data['email'])->subject('New enquiry: ' . $data['name']));
        } catch (\Throwable $e) {
            Log::warning('Lead email failed: ' . $e->getMessage());
        }
        return redirect()->route('contact')->with('sent', true);
    }
}
