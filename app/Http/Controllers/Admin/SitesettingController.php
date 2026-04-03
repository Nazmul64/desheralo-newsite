<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sitesetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SitesettingController extends Controller
{
    // Upload directory (inside public/)
    private string $uploadPath = 'uploads/settings';

    // ─── Index ────────────────────────────────────────────────────────────────
    public function index()
    {
        $sitesettings = Sitesetting::latest()->get();
        return view('admin.sitesetting.index', compact('sitesettings'));
    }

    // ─── Create ───────────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.sitesetting.create');
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'short_name'     => 'required|string|max:100',
            'footer_content' => 'nullable|string',
            'play_store_url' => 'nullable|url|max:500',
            'app_store_url'  => 'nullable|url|max:500',
            'favicon'        => 'nullable|image|mimes:png,jpg,jpeg,ico,svg|max:2048',
            'icon'           => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'logo'           => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'footer_logo'    => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $data = $request->only([
            'title', 'name', 'short_name', 'footer_content',
            'play_store_url', 'app_store_url',
        ]);

        // Ensure directory exists
        $this->ensureUploadDir();

        // Handle image uploads → public/uploads/settings/
        foreach (['favicon', 'icon', 'logo', 'footer_logo'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $this->uploadFile($request->file($field));
            }
        }

        Sitesetting::create($data);

        return redirect()->route('sitesetting.index')
            ->with('success', 'Site setting created successfully.');
    }

    // ─── Show ─────────────────────────────────────────────────────────────────
    public function show(string $id)
    {
        $sitesetting = Sitesetting::findOrFail($id);
        return view('admin.sitesetting.show', compact('sitesetting'));
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $sitesetting = Sitesetting::findOrFail($id);
        return view('admin.sitesetting.edit', compact('sitesetting'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $sitesetting = Sitesetting::findOrFail($id);

        $request->validate([
            'title'          => 'required|string|max:255',
            'name'           => 'required|string|max:255',
            'short_name'     => 'required|string|max:100',
            'footer_content' => 'nullable|string',
            'play_store_url' => 'nullable|url|max:500',
            'app_store_url'  => 'nullable|url|max:500',
            'favicon'        => 'nullable|image|mimes:png,jpg,jpeg,ico,svg|max:2048',
            'icon'           => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'logo'           => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'footer_logo'    => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $data = $request->only([
            'title', 'name', 'short_name', 'footer_content',
            'play_store_url', 'app_store_url',
        ]);

        // Ensure directory exists
        $this->ensureUploadDir();

        // Handle image uploads → delete old → save new
        foreach (['favicon', 'icon', 'logo', 'footer_logo'] as $field) {
            if ($request->hasFile($field)) {
                // Delete old file from public/uploads/settings/
                $this->deleteFile($sitesetting->$field);
                // Save new file
                $data[$field] = $this->uploadFile($request->file($field));
            }
        }

        $sitesetting->update($data);

        return redirect()->route('sitesetting.index')
            ->with('success', 'Site setting updated successfully.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────
    public function destroy(string $id)
    {
        $sitesetting = Sitesetting::findOrFail($id);

        // Delete all stored images from public/uploads/settings/
        foreach (['favicon', 'icon', 'logo', 'footer_logo'] as $field) {
            $this->deleteFile($sitesetting->$field);
        }

        $sitesetting->delete();

        return redirect()->route('sitesetting.index')
            ->with('success', 'Site setting deleted successfully.');
    }

    // ─── Bulk Destroy ─────────────────────────────────────────────────────────
    public function bulkDestroy(Request $request)
    {
        $ids      = explode(',', $request->ids);
        $settings = Sitesetting::whereIn('id', $ids)->get();

        foreach ($settings as $sitesetting) {
            foreach (['favicon', 'icon', 'logo', 'footer_logo'] as $field) {
                $this->deleteFile($sitesetting->$field);
            }
            $sitesetting->delete();
        }

        return response()->json(['success' => 'Selected records deleted successfully.']);
    }

    // ─── Toggle Status ────────────────────────────────────────────────────────
    public function toggleStatus(string $id)
    {
        return response()->json(['message' => 'Status toggled.']);
    }

    // ─── Toggle Breaking ──────────────────────────────────────────────────────
    public function toggleBreaking(string $id)
    {
        return response()->json(['message' => 'Breaking toggled.']);
    }

    // ─── Get Subcategories ────────────────────────────────────────────────────
    public function getSubcategories(Request $request)
    {
        return response()->json([]);
    }

    // =========================================================================
    // ─── Private Helpers ─────────────────────────────────────────────────────
    // =========================================================================

    /**
     * Ensure public/uploads/settings/ directory exists.
     */
    private function ensureUploadDir(): void
    {
        $dir = public_path($this->uploadPath);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
    }

    /**
     * Upload a file to public/uploads/settings/
     * Returns the relative path stored in DB:  uploads/settings/filename.ext
     */
    private function uploadFile(\Illuminate\Http\UploadedFile $file): string
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($this->uploadPath), $filename);
        return $this->uploadPath . '/' . $filename;
    }

    /**
     * Delete a file from public/ given its relative path.
     * e.g.  uploads/settings/abc.png  →  public/uploads/settings/abc.png
     */
    private function deleteFile(?string $relativePath): void
    {
        if ($relativePath && File::exists(public_path($relativePath))) {
            File::delete(public_path($relativePath));
        }
    }
}
