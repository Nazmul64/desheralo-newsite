<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThemesettingController extends Controller
{
    // ─── Upload directory (relative to public/) ───────────────────────────────
    private const UPLOAD_DIR = 'uploads/themesettings';

    // ─── Index ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $search  = $request->input('search');

        $themes = Theme::query()
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%")
                                         ->orWhere('author', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.themesetting.index', compact('themes', 'perPage', 'search'));
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'version'      => 'required|string|max:50',
            'home_page_id' => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'description'  => 'nullable|string',
        ]);

        $validated['image'] = $this->handleUpload($request);

        Theme::create($validated);

        return redirect()->route('themesettings.index')
                         ->with('success', 'Theme created successfully.');
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $theme = Theme::findOrFail($id);
        return view('admin.themesetting.edit', compact('theme'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $theme = Theme::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'version'      => 'required|string|max:50',
            'home_page_id' => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'description'  => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteOldImage($theme->image);
            $validated['image'] = $this->handleUpload($request);
        }

        $theme->update($validated);

        return redirect()->route('themesettings.index')
                         ->with('success', 'Theme updated successfully.');
    }

    // ─── Toggle Status ────────────────────────────────────────────────────────
    public function toggleStatus(string $id)
    {
        $theme = Theme::findOrFail($id);
        $theme->update([
            'status' => $theme->isActivated() ? 'deactivated' : 'activated',
        ]);

        return redirect()->back()->with('success', 'Theme status updated.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────
    public function destroy(string $id)
    {
        $theme = Theme::findOrFail($id);
        $this->deleteOldImage($theme->image);
        $theme->delete();

        return redirect()->route('themesettings.index')
                         ->with('success', 'Theme deleted successfully.');
    }

    // ─── Bulk Destroy ─────────────────────────────────────────────────────────
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:themes,id',
        ]);

        // ✅ FIX: ensure $ids is always a proper array
        $ids = (array) $request->input('ids', []);

        $deletedCount = 0;

        Theme::whereIn('id', $ids)->each(function ($theme) use (&$deletedCount) {
            $this->deleteOldImage($theme->image);
            $theme->delete();
            $deletedCount++;
        });

        return redirect()->route('themesettings.index')
                         ->with('success', $deletedCount . ' themes deleted.');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function handleUpload(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $dir = public_path(self::UPLOAD_DIR);
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $file     = $request->file('image');
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    . '.' . $file->getClientOriginalExtension();

        $file->move($dir, $filename);

        return $filename;
    }

    private function deleteOldImage(?string $filename): void
    {
        if ($filename) {
            $path = public_path(self::UPLOAD_DIR . '/' . $filename);
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
