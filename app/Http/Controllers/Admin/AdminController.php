<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ContentRevision, Lead, Package, Post, SeoSetting, Service, SiteSetting};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    const STATUSES = ['new', 'contacted', 'proposal', 'won', 'lost'];

    public function dashboard()
    {
        $weekStart = now()->startOfDay()->subDays(6);
        $dailyTotals = Lead::where('created_at', '>=', $weekStart)
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');
        $weeklyLeads = collect(range(6, 0))->map(function (int $daysAgo) use ($dailyTotals) {
            $date = now()->startOfDay()->subDays($daysAgo);
            $count = (int) $dailyTotals->get($date->toDateString(), 0);

            return ['label' => $date->format('D'), 'date' => $date->format('d M'), 'count' => $count];
        });
        $maxDailyLeads = max(1, $weeklyLeads->max('count'));
        $weeklyLeads = $weeklyLeads->map(fn ($day) => $day + ['height' => $day['count'] ? max(12, (int) round($day['count'] / $maxDailyLeads * 100)) : 0]);
        $statusCounts = Lead::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $newLeads = (int) $statusCounts->get('new', 0);
        $proposalLeads = (int) $statusCounts->get('proposal', 0);
        $wonLeads = (int) $statusCounts->get('won', 0);
        $activeLeads = $newLeads + (int) $statusCounts->get('contacted', 0) + $proposalLeads;

        return view('admin.dashboard', [
            'metrics' => [
                ['label' => 'All leads', 'value' => Lead::count(), 'note' => 'Every enquiry received', 'tone' => 'ink'],
                ['label' => 'Needs attention', 'value' => $newLeads, 'note' => 'New enquiries to review', 'tone' => 'amber'],
                ['label' => 'In pipeline', 'value' => $activeLeads, 'note' => 'New, contacted or proposed', 'tone' => 'teal'],
                ['label' => 'Won', 'value' => $wonLeads, 'note' => 'Projects marked won', 'tone' => 'green'],
            ],
            'weeklyLeads' => $weeklyLeads,
            'statusCounts' => collect(self::STATUSES)->mapWithKeys(fn ($status) => [$status => (int) $statusCounts->get($status, 0)]),
            'contentCounts' => ['Services' => Service::where('active', true)->count(), 'Packages' => Package::where('active', true)->count(), 'Posts' => Post::where('published_at', '<=', now())->count()],
            'latest' => Lead::latest()->take(8)->get(),
        ]);
    }

    // ---- Leads ----
    public function leads(Request $r)
    {
        $q = Lead::latest();
        if ($r->filled('status')) $q->where('status', $r->status);
        if ($r->filled('q')) $q->where(fn ($w) => $w->where('name', 'like', "%{$r->q}%")->orWhere('email', 'like', "%{$r->q}%")->orWhere('company', 'like', "%{$r->q}%"));
        return view('admin.leads', ['leads' => $q->paginate(20)->withQueryString(), 'statuses' => self::STATUSES]);
    }

    public function leadUpdate(Request $r, Lead $lead)
    {
        $lead->update($r->validate(['status' => 'required|in:' . implode(',', self::STATUSES), 'notes' => 'nullable|string|max:3000']));
        return back()->with('ok', 'Lead updated.');
    }

    public function leadDelete(Lead $lead) { $lead->delete(); return back()->with('ok', 'Lead deleted.'); }

    public function seo()
    {
        return view('admin.seo', [
            'pages' => config('stackspring.seo_pages'),
            'settings' => SeoSetting::all()->keyBy('page_key'),
        ]);
    }

    public function seoUpdate(Request $request)
    {
        $pages = config('stackspring.seo_pages');
        $rules = ['seo' => 'required|array'];
        foreach (array_keys($pages) as $key) {
            $rules["seo.$key"] = 'required|array';
            $rules["seo.$key.meta_title"] = 'nullable|string|max:70';
            $rules["seo.$key.meta_description"] = 'nullable|string|max:300';
            $rules["seo.$key.meta_robots"] = 'required|in:index,noindex,none';
            $rules["seo.$key.og_image"] = 'nullable|url|max:2048';
        }

        $data = $request->validate($rules);
        foreach (array_keys($pages) as $key) {
            SeoSetting::updateOrCreate(['page_key' => $key], $data['seo'][$key]);
        }

        return redirect()->route('admin.seo')->with('ok', 'SEO settings saved.');
    }

    public function siteSettings()
    {
        return view('admin.site-settings', [
            'fields' => config('stackspring.shell_settings'),
            'settings' => SiteSetting::values(),
        ]);
    }

    public function siteSettingsUpdate(Request $request)
    {
        $fields = config('stackspring.shell_settings');
        $rules = [];
        foreach ($fields as $key => $field) {
            $rules[$key] = match ($field['type']) {
                'checkbox' => 'sometimes|boolean',
                'email' => 'nullable|email|max:190',
                'textarea' => 'nullable|string|max:1000',
                'image' => 'nullable|image|max:4096',
                default => 'nullable|string|max:500',
            };
        }

        $data = $request->validate($rules);
        foreach ($fields as $key => $field) {
            if ($field['type'] === 'image') {
                if ($request->hasFile($key)) {
                    $oldPath = SiteSetting::where('key', $key)->value('value');
                    $value = $request->file($key)->store('site', 'public');
                    if ($oldPath && str_starts_with($oldPath, 'site/') && Storage::disk('public')->exists($oldPath)) Storage::disk('public')->delete($oldPath);
                } else {
                    continue;
                }
            } else {
                $value = $field['type'] === 'checkbox'
                    ? ($request->boolean($key) ? '1' : '0')
                    : trim((string) ($data[$key] ?? ''));
            }

            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.site-settings')->with('ok', 'Site header and footer settings saved.');
    }

    public function pageContent()
    {
        $allPages = config('page_content');
        $deletedPageKeys = collect(array_keys($allPages))->filter(fn ($key) => $this->builtInPageStatus($key) === 'deleted');
        return view('admin.pages', [
            'pages' => collect($allPages)->except($deletedPageKeys)->all(),
            'seo' => SeoSetting::all()->keyBy('page_key'),
            'customPages' => \App\Models\Page::whereNotIn('slug', ['home', 'about', 'ai-solutions', 'services', 'packages', 'blog', 'contact'])->orderBy('title')->get(),
            'trashedCount' => \App\Models\Page::onlyTrashed()->count() + $deletedPageKeys->count(),
        ]);
    }

    public function deleteBuiltInPage(string $pageKey)
    {
        config("page_content.$pageKey") ?? abort(404);
        $this->saveRevision('site-page', $pageKey, $this->sitePageSnapshot($pageKey), 'deleted');
        SiteSetting::updateOrCreate(['key' => "page_status.$pageKey"], ['value' => 'deleted']);
        return redirect()->route('admin.index', 'pages')->with('ok', 'Page moved to Trash. You can restore it later.');
    }

    public function restoreBuiltInPage(string $pageKey)
    {
        config("page_content.$pageKey") ?? abort(404);
        SiteSetting::updateOrCreate(['key' => "page_status.$pageKey"], ['value' => 'published']);
        $this->saveRevision('site-page', $pageKey, $this->sitePageSnapshot($pageKey), 'restored');
        return redirect()->route('admin.trash', 'pages')->with('ok', 'Page restored.');
    }

    private function builtInPageStatus(string $pageKey): string
    {
        return SiteSetting::where('key', "page_status.$pageKey")->value('value') ?: 'published';
    }

    public function pageContentEdit(string $pageKey)
    {
        $section = config("page_content.$pageKey") ?? abort(404);
        $keys = array_map(fn ($key) => "content.$pageKey.$key", array_keys($section['fields']));
        $stored = SiteSetting::whereIn('key', $keys)->pluck('value', 'key');
        $content = [];
        foreach ($section['fields'] as $key => $field) $content[$key] = $stored->get("content.$pageKey.$key", $field['default']);
        $seoKey = $pageKey === 'ai' ? 'ai-solutions' : $pageKey;
        $aboutPage = $pageKey === 'about' ? \App\Models\Page::where('slug', 'about')->firstOrFail() : null;
        $seo = SeoSetting::forPage($seoKey);
        if ($aboutPage) {
            $seo->meta_title = $aboutPage->meta_title ?: $seo->meta_title;
            $seo->meta_description = $aboutPage->meta_description ?: $seo->meta_description;
            $seo->meta_robots = $aboutPage->meta_robots ?: $seo->meta_robots;
            $seo->og_image = $aboutPage->og_image ?: $seo->og_image;
        }
        return view('admin.page-edit', [
            'pageKey' => $pageKey,
            'page' => $section,
            'content' => $content,
            'seo' => $seo,
            'aboutPage' => $aboutPage,
            'revisions' => $this->revisions('site-page', $pageKey),
        ]);
    }

    public function pageContentUpdate(Request $request, string $pageKey)
    {
        $section = config("page_content.$pageKey") ?? abort(404);
        $rules = ['seo.meta_title' => 'nullable|string|max:70', 'seo.meta_description' => 'nullable|string|max:300', 'seo.meta_robots' => 'required|in:index,noindex,none', 'seo.og_image' => 'nullable|url|max:2048'];
        foreach ($section['fields'] as $key => $field) $rules["content.$key"] = 'nullable|string|max:2000';
        if ($pageKey === 'about') { $rules['page_title'] = 'required|string|max:150'; $rules['page_body'] = 'nullable|string'; }
        $data = $request->validate($rules);
        $this->saveRevision('site-page', $pageKey, $this->sitePageSnapshot($pageKey), 'before_update');
        foreach ($section['fields'] as $key => $field) SiteSetting::updateOrCreate(['key' => "content.$pageKey.$key"], ['value' => trim((string) data_get($data, "content.$key", ''))]);
        $seoKey = $pageKey === 'ai' ? 'ai-solutions' : $pageKey;
        SeoSetting::updateOrCreate(['page_key' => $seoKey], $data['seo']);
        if ($pageKey === 'about') \App\Models\Page::where('slug', 'about')->firstOrFail()->update([
            'title' => $data['page_title'], 'body' => $data['page_body'] ?? '',
            'meta_title' => $data['seo']['meta_title'] ?? null, 'meta_description' => $data['seo']['meta_description'] ?? null,
            'meta_robots' => $data['seo']['meta_robots'], 'og_image' => $data['seo']['og_image'] ?? null,
        ]);
        return redirect()->route('admin.page-content.edit', $pageKey)->with('ok', $section['label'] . ' content and SEO saved.');
    }

    public function restoreSitePageRevision(string $pageKey, int $revisionId)
    {
        config("page_content.$pageKey") ?? abort(404);
        $revision = ContentRevision::where('record_type', 'site-page')->where('record_id', $pageKey)->findOrFail($revisionId);
        $this->saveRevision('site-page', $pageKey, $this->sitePageSnapshot($pageKey), 'before_revision_restore');
        foreach ($revision->snapshot['content'] ?? [] as $key => $value) SiteSetting::updateOrCreate(['key' => "content.$pageKey.$key"], ['value' => $value]);
        $seoKey = $pageKey === 'ai' ? 'ai-solutions' : $pageKey;
        if (!empty($revision->snapshot['seo'])) SeoSetting::updateOrCreate(['page_key' => $seoKey], $revision->snapshot['seo']);
        if ($pageKey === 'about' && !empty($revision->snapshot['about'])) \App\Models\Page::where('slug', 'about')->firstOrFail()->update($revision->snapshot['about']);
        if (!empty($revision->snapshot['status'])) SiteSetting::updateOrCreate(['key' => "page_status.$pageKey"], ['value' => $revision->snapshot['status']]);
        $this->saveRevision('site-page', $pageKey, $this->sitePageSnapshot($pageKey), 'restored_revision');
        return redirect()->route('admin.page-content.edit', $pageKey)->with('ok', 'Page revision restored.');
    }

    private function sitePageSnapshot(string $pageKey): array
    {
        $section = config("page_content.$pageKey") ?? abort(404);
        $content = [];
        foreach (array_keys($section['fields']) as $key) $content[$key] = SiteSetting::where('key', "content.$pageKey.$key")->value('value') ?? $section['fields'][$key]['default'];
        $seoKey = $pageKey === 'ai' ? 'ai-solutions' : $pageKey;
        $snapshot = ['content' => $content, 'seo' => (array) SeoSetting::forPage($seoKey), 'status' => $this->builtInPageStatus($pageKey)];
        if ($pageKey === 'about') $snapshot['about'] = \App\Models\Page::where('slug', 'about')->firstOrFail()->only(['title', 'body', 'meta_title', 'meta_description', 'meta_robots', 'og_image']);
        return $snapshot;
    }

    // ---- Generic CRUD for services / packages / posts / pages ----
    private function cfg(string $r): array { return config("admin.$r") ?? abort(404); }

    public function index(string $r)
    {
        if ($r === 'pages') return $this->pageContent();
        $c = $this->cfg($r);
        $query = $c['model']::query();
        if (request()->filled('q')) {
            $term = request('q');
            $query->where(function ($where) use ($r, $term) {
                $searchFields = ['services' => ['title', 'slug', 'summary'], 'packages' => ['name', 'description'], 'posts' => ['title', 'slug', 'excerpt'], 'pages' => ['title', 'slug']][$r];
                foreach ($searchFields as $field) $where->orWhere($field, 'like', "%{$term}%");
            });
        }
        if (request()->filled('status')) {
            if (in_array($r, ['services', 'packages'], true)) $query->where('active', request('status') === 'active');
            if ($r === 'posts') request('status') === 'published' ? $query->where('published_at', '<=', now()) : $query->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '>', now()));
            if ($r === 'pages') $query->where('status', request('status'));
        }
        $sort = $r === 'services' || $r === 'packages' ? ['sort', 'asc'] : ['id', 'desc'];
        return view('admin.index', ['r' => $r, 'c' => $c, 'rows' => $query->orderBy($sort[0], $sort[1])->paginate(20)->withQueryString()]);
    }

    public function create(string $r) { return view('admin.form', ['r' => $r, 'c' => $this->cfg($r), 'item' => null]); }

    public function edit(string $r, int $id)
    {
        $c = $this->cfg($r);
        $item = $c['model']::findOrFail($id);
        return view('admin.form', ['r' => $r, 'c' => $c, 'item' => $item, 'revisions' => $this->revisions($r, $item->id)]);
    }

    public function store(Request $req, string $r)
    {
        $c = $this->cfg($r);
        $item = $c['model']::create($this->data($req, $c));
        $this->saveRevision($r, $item->id, $this->snapshot($item), 'created');
        return redirect()->route('admin.index', $r)->with('ok', 'Saved.');
    }

    public function update(Request $req, string $r, int $id)
    {
        $c = $this->cfg($r);
        $item = $c['model']::findOrFail($id);
        $this->saveRevision($r, $id, $this->snapshot($item), 'before_update');
        $item->update($this->data($req, $c, $id));
        return redirect()->route('admin.index', $r)->with('ok', 'Updated.');
    }

    public function destroy(string $r, int $id)
    {
        $c = $this->cfg($r);
        $item = $c['model']::findOrFail($id);
        if ($r === 'pages' && in_array($item->slug, ['home', 'about', 'ai-solutions', 'services', 'packages', 'blog', 'contact'], true)) abort(422, 'Built-in pages cannot be moved to trash.');
        $this->saveRevision($r, $id, $this->snapshot($item), 'deleted');
        $item->delete();
        return redirect()->route('admin.index', $r)->with('ok', 'Moved to trash. You can restore it later.');
    }

    public function trash(string $r)
    {
        $c = $this->cfg($r);
        $fixedDeleted = $r === 'pages'
            ? collect(config('page_content'))->filter(fn ($page, $key) => $this->builtInPageStatus($key) === 'deleted')->map(fn ($page, $key) => ['key' => $key, 'label' => $page['label']])->values()
            : collect();
        return view('admin.trash', ['r' => $r, 'c' => $c, 'rows' => $c['model']::onlyTrashed()->latest('deleted_at')->paginate(20), 'fixedDeleted' => $fixedDeleted]);
    }

    public function restore(string $r, int $id)
    {
        $c = $this->cfg($r);
        $item = $c['model']::onlyTrashed()->findOrFail($id);
        $item->restore();
        $this->saveRevision($r, $item->id, $this->snapshot($item), 'restored');
        return redirect()->route('admin.trash', $r)->with('ok', 'Item restored.');
    }

    public function restoreRevision(string $r, int $id, int $revisionId)
    {
        $c = $this->cfg($r);
        $item = $c['model']::findOrFail($id);
        $revision = ContentRevision::where('record_type', $r)->where('record_id', (string) $id)->findOrFail($revisionId);
        $this->saveRevision($r, $id, $this->snapshot($item), 'before_revision_restore');
        $item->fill($revision->snapshot)->save();
        $this->saveRevision($r, $id, $this->snapshot($item), 'restored_revision');
        return redirect()->route('admin.edit', [$r, $id])->with('ok', 'Revision restored.');
    }

    private function snapshot($item): array
    {
        return collect($item->getAttributes())->except(['id', 'created_at', 'updated_at', 'deleted_at'])->all();
    }

    private function saveRevision(string $type, int|string $id, array $snapshot, string $action): void
    {
        ContentRevision::create(['record_type' => $type, 'record_id' => (string) $id, 'action' => $action, 'snapshot' => $snapshot, 'user_id' => auth()->id()]);
    }

    private function revisions(string $type, int|string $id)
    {
        return ContentRevision::where('record_type', $type)->where('record_id', (string) $id)->latest()->take(20)->get();
    }

    private function data(Request $req, array $c, ?int $id = null): array
    {
        $data = $req->validate(collect($c['fields'])->map(fn ($f) => $f[1])->all());
        foreach ($c['fields'] as $k => [$type]) {
            if ($type === 'checkbox') $data[$k] = $req->boolean($k);
            if ($type === 'number') $data[$k] = (int) ($data[$k] ?? 0);
        }
        if (array_key_exists('slug', $c['fields'])) {
            $slug = Str::slug($data['slug'] ?: ($data['title'] ?? ''));
            if ($c['model'] === \App\Models\Page::class) {
                $req->merge(['slug' => $slug]);
                $req->validate(['slug' => 'required|not_in:home,about,ai-solutions,services,packages,blog,contact,sitemap.xml,admin']);
            }
            $base = $slug; $i = 2;
            while ($c['model']::where('slug', $slug)->when($id, fn ($q) => $q->where('id', '!=', $id))->exists()) $slug = $base . '-' . $i++;
            $data['slug'] = $slug;
        }
        return $data;
    }
}
