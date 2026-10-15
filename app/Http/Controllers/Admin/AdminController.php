<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Lead, Package, Post, Service};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    const STATUSES = ['new', 'contacted', 'proposal', 'won', 'lost'];

    public function dashboard()
    {
        return view('admin.dashboard', [
            'counts' => ['Leads' => Lead::count(), 'New leads' => Lead::where('status', 'new')->count(),
                'Won' => Lead::where('status', 'won')->count(), 'Services' => Service::count(),
                'Packages' => Package::count(), 'Posts' => Post::count()],
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

    // ---- Generic CRUD for services / packages / posts / pages ----
    private function cfg(string $r): array { return config("admin.$r") ?? abort(404); }

    public function index(string $r)
    {
        $c = $this->cfg($r);
        return view('admin.index', ['r' => $r, 'c' => $c, 'rows' => $c['model']::latest('id')->paginate(25)]);
    }

    public function create(string $r) { return view('admin.form', ['r' => $r, 'c' => $this->cfg($r), 'item' => null]); }

    public function edit(string $r, int $id)
    {
        $c = $this->cfg($r);
        return view('admin.form', ['r' => $r, 'c' => $c, 'item' => $c['model']::findOrFail($id)]);
    }

    public function store(Request $req, string $r)
    {
        $c = $this->cfg($r);
        $c['model']::create($this->data($req, $c));
        return redirect()->route('admin.index', $r)->with('ok', 'Saved.');
    }

    public function update(Request $req, string $r, int $id)
    {
        $c = $this->cfg($r);
        $c['model']::findOrFail($id)->update($this->data($req, $c, $id));
        return redirect()->route('admin.index', $r)->with('ok', 'Updated.');
    }

    public function destroy(string $r, int $id)
    {
        $c = $this->cfg($r);
        $c['model']::findOrFail($id)->delete();
        return back()->with('ok', 'Deleted.');
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
            $base = $slug; $i = 2;
            while ($c['model']::where('slug', $slug)->when($id, fn ($q) => $q->where('id', '!=', $id))->exists()) $slug = $base . '-' . $i++;
            $data['slug'] = $slug;
        }
        return $data;
    }
}
