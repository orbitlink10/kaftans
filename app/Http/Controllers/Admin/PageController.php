<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    private string $store = 'pages.json';

    public function index(Request $request)
    {
        $pages = collect($this->pages())
            ->sortByDesc(fn ($page) => (int) ($page['id'] ?? 0))
            ->values();
        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        return view('admin.pages.index', [
            'posts' => new LengthAwarePaginator(
                $pages->forPage($currentPage, $perPage)->values(),
                $pages->count(),
                $perPage,
                $currentPage,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ],
            ),
        ]);
    }

    public function create()
    {
        return view('admin.pages.form', [
            'page' => null,
            'action' => route('admin.pages.store'),
            'method' => 'POST',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $pages = $this->pages(false);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages', 'public');
        }

        $data['id'] = empty($pages) ? 1 : ((int) collect($pages)->max('id') + 1);
        $data['slug'] = $this->uniqueSlug($data['title'], $pages);
        $data['alt'] = $data['alt'] ?: $data['title'];

        $pages[] = $data;
        $this->save($pages);

        return redirect()->route('admin.pages')->with('success', 'Page saved and ready to preview.');
    }

    public function edit(int $id)
    {
        $page = collect($this->pages())->firstWhere('id', $id);
        abort_if(! $page, 404);

        return view('admin.pages.form', [
            'page' => $page,
            'action' => route('admin.pages.update', $id),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validated($request);
        $pages = $this->pages(false);
        $index = collect($pages)->search(fn ($page) => (int) ($page['id'] ?? 0) === $id);

        abort_if($index === false, 404);

        $existing = $pages[$index];
        $otherPages = collect($pages)->reject(fn ($page) => (int) ($page['id'] ?? 0) === $id)->values()->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages', 'public');
        } else {
            $data['image'] = $existing['image'] ?? null;
        }

        $data['id'] = $id;
        $data['slug'] = $this->uniqueSlug($data['title'], $otherPages);
        $data['alt'] = $data['alt'] ?: $data['title'];

        $pages[$index] = $data;
        $this->save(array_values($pages));

        return redirect()->route('admin.pages')->with('success', 'Page updated.');
    }

    public function destroy(int $id)
    {
        $pages = collect($this->pages(false))
            ->reject(fn ($page) => (int) ($page['id'] ?? 0) === $id)
            ->values()
            ->all();

        $this->save($pages);

        return redirect()->route('admin.pages')->with('success', 'Page deleted.');
    }

    public function preview(string $slug)
    {
        $page = collect($this->pages(false))->firstWhere('slug', $slug);
        abort_if(! $page, 404);

        return view('pages.show', [
            'page' => $page,
            'image' => $this->imageUrl($page['image'] ?? null),
        ]);
    }

    public function image(string $path)
    {
        $path = ltrim(rawurldecode($path), '/');

        abort_if($path === '' || str_contains($path, '..') || ! Storage::disk('public')->exists($path), 404);

        return response(Storage::disk('public')->get($path), 200)
            ->header('Content-Type', Storage::disk('public')->mimeType($path) ?: 'application/octet-stream')
            ->header('Cache-Control', 'public, max-age=604800');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'meta_title' => ['required', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:180'],
            'alt' => ['nullable', 'string', 'max:160'],
            'heading_2' => ['nullable', 'string', 'max:180'],
            'type' => ['required', 'in:Post,Page'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function pages(bool $seed = true): array
    {
        $pages = [];

        if (Storage::disk('local')->exists($this->store)) {
            $pages = json_decode(Storage::disk('local')->get($this->store), true) ?? [];
        }

        if ($seed && empty($pages)) {
            $pages = [[
                'id' => 1,
                'title' => 'Lasafi Cleaning Services in Kenya',
                'slug' => 'lasafi-cleaning-services-in-kenya',
                'alt' => 'Lasafi Cleaning Services in Kenya',
                'heading_2' => 'Professional Cleaning Services',
                'type' => 'Post',
                'description' => '<p>Publish your Lasafi page content here.</p>',
                'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=800&q=80',
                'meta_title' => 'Lasafi Cleaning Services in Kenya',
                'meta_description' => 'Book vetted cleaning and home service teams across Kenya.',
            ]];
        }

        $pages = collect($pages)->map(function ($page) {
            $page['slug'] = $page['slug'] ?? Str::slug($page['title'] ?? 'page');
            $page['alt'] = $page['alt'] ?? ($page['title'] ?? '');
            $page['type'] = $page['type'] ?? 'Post';

            return $page;
        })->values()->all();

        if ($seed) {
            $this->save($pages);
        }

        return $pages;
    }

    private function save(array $pages): void
    {
        Storage::disk('local')->put($this->store, json_encode($pages, JSON_PRETTY_PRINT));
    }

    private function uniqueSlug(string $title, array $pages): string
    {
        $base = Str::slug($title) ?: 'page';
        $slug = $base;
        $existing = collect($pages)->pluck('slug')->filter()->all();
        $counter = 1;

        while (in_array($slug, $existing, true)) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }

    private function imageUrl(?string $image): string
    {
        if (! $image) {
            return 'https://via.placeholder.com/900x460?text=No+Image';
        }

        if (Str::startsWith($image, ['http://', 'https://', '//'])) {
            return $image;
        }

        return route('pages.image', ['path' => ltrim($image, '/')]);
    }
}
