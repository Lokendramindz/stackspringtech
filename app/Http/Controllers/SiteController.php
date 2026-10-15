<?php

namespace App\Http\Controllers;

use App\Models\{Lead, Package, Page, Post, Service};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    private function activeServices() { return Service::where('active', true)->orderBy('sort')->get(); }

    public function home()
    {
        return view('site.home', [
            'services' => $this->activeServices(),
            'packages' => Package::where('active', true)->orderBy('sort')->get(),
            'posts' => Post::where('published_at', '<=', now())->latest('published_at')->take(3)->get(),
        ]);
    }

    public function about() { return view('site.page', ['page' => Page::where('slug', 'about')->firstOrFail()]); }
    public function services() { return view('site.services', ['services' => $this->activeServices()]); }

    public function packages() { return view('site.packages', ['packages' => Package::where('active', true)->orderBy('sort')->get()]); }

    public function blog() { return view('site.blog', ['posts' => Post::where('published_at', '<=', now())->latest('published_at')->paginate(9)]); }

    public function post(string $slug) { return view('site.post', ['post' => Post::where('slug', $slug)->where('published_at', '<=', now())->firstOrFail()]); }

    public function service(string $slug) { return view('site.service', ['s' => Service::where('slug', $slug)->where('active', true)->firstOrFail()]); }

    public function contact(Request $r)
    {
        return view('site.contact', [
            'services' => $this->activeServices(),
            'packages' => Package::where('active', true)->orderBy('sort')->get(),
            'pre' => $r->query('package'),
        ]);
    }

    public function sitemap()
    {
        $urls = collect(['home', 'about', 'services', 'packages', 'blog', 'contact'])->map(fn ($r) => ['loc' => route($r), 'lastmod' => null]);
        foreach (Service::where('active', true)->get() as $x) $urls->push(['loc' => route('service', $x->slug), 'lastmod' => $x->updated_at]);
        foreach (Post::where('published_at', '<=', now())->get() as $x) $urls->push(['loc' => route('post', $x->slug), 'lastmod' => $x->updated_at]);
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
            Mail::raw("New lead #{$lead->id}\n\n" . collect($data)->map(fn ($v, $k) => ucfirst($k) . ': ' . $v)->implode("\n"),
                fn ($m) => $m->to(config('stackspring.email'))->replyTo($data['email'])->subject('New enquiry: ' . $data['name']));
        } catch (\Throwable $e) {
            Log::warning('Lead email failed: ' . $e->getMessage());
        }
        return redirect()->route('contact')->with('sent', true);
    }
}
