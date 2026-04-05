<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admanager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdmanagerController extends Controller
{
    /** Ads upload directory (inside public/uploads/ads) */
    private string $uploadDir;

    public function __construct()
    {
        $this->uploadDir = public_path('uploads/ads');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // INDEX
    // ─────────────────────────────────────────────────────────────────────────

    public function index()
    {
        $ads = Admanager::latest()->get();
        return view('admin.admanager.index', compact('ads'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // CREATE
    // ─────────────────────────────────────────────────────────────────────────

    public function create()
    {
        return view('admin.admanager.create');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // STORE
    // ─────────────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'header_ads_type'      => 'required|in:code,image',
            'sidebar_ads_type'     => 'required|in:code,image',
            'before_post_ads_type' => 'required|in:code,image',
            'after_post_ads_type'  => 'required|in:code,image',
            'header_ads_image'     => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'sidebar_ads_image'    => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'before_post_ads_image'=> 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'after_post_ads_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = [
            'header_ads_type'      => $request->header_ads_type,
            'sidebar_ads_type'     => $request->sidebar_ads_type,
            'before_post_ads_type' => $request->before_post_ads_type,
            'after_post_ads_type'  => $request->after_post_ads_type,
            'status'               => $request->boolean('status', true),
        ];

        // Handle each ad slot
        foreach (['header_ads', 'sidebar_ads', 'before_post_ads', 'after_post_ads'] as $field) {
            $type = $request->{$field . '_type'};

            if ($type === 'image') {
                $data[$field] = $this->uploadImage($request, $field . '_image');
            } else {
                $data[$field] = $request->input($field);
            }
        }

        Admanager::create($data);

        return response()->json(['success' => true, 'message' => 'Ad created successfully.']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EDIT
    // ─────────────────────────────────────────────────────────────────────────

    public function edit(string $id)
    {
        $ad = Admanager::findOrFail($id);

        // If AJAX request from modal, return JSON
        if (request()->ajax()) {
            return response()->json(['ad' => $ad]);
        }

        return view('admin.admanager.edit', compact('ad'));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // UPDATE
    // ─────────────────────────────────────────────────────────────────────────

    public function update(Request $request, string $id)
    {
        $ad = Admanager::findOrFail($id);

        $request->validate([
            'header_ads_type'      => 'required|in:code,image',
            'sidebar_ads_type'     => 'required|in:code,image',
            'before_post_ads_type' => 'required|in:code,image',
            'after_post_ads_type'  => 'required|in:code,image',
            'header_ads_image'     => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'sidebar_ads_image'    => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'before_post_ads_image'=> 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'after_post_ads_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $data = [
            'header_ads_type'      => $request->header_ads_type,
            'sidebar_ads_type'     => $request->sidebar_ads_type,
            'before_post_ads_type' => $request->before_post_ads_type,
            'after_post_ads_type'  => $request->after_post_ads_type,
            'status'               => $request->boolean('status', true),
        ];

        foreach (['header_ads', 'sidebar_ads', 'before_post_ads', 'after_post_ads'] as $field) {
            $type = $request->{$field . '_type'};

            if ($type === 'image') {
                $newImage = $this->uploadImage($request, $field . '_image');
                if ($newImage) {
                    // Delete old image if it was an image type
                    $this->deleteImage($ad->{$field});
                    $data[$field] = $newImage;
                } else {
                    // Keep existing image
                    $data[$field] = $ad->{$field};
                }
            } else {
                // If switching from image to code, remove old image
                if ($ad->{$field . '_type'} === 'image' && $ad->{$field}) {
                    $this->deleteImage($ad->{$field});
                }
                $data[$field] = $request->input($field);
            }
        }

        $ad->update($data);

        return response()->json(['success' => true, 'message' => 'Ad updated successfully.']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // DESTROY
    // ─────────────────────────────────────────────────────────────────────────

    public function destroy(string $id)
    {
        $ad = Admanager::findOrFail($id);

        // Delete uploaded images
        foreach (['header_ads', 'sidebar_ads', 'before_post_ads', 'after_post_ads'] as $field) {
            if ($ad->{$field . '_type'} === 'image') {
                $this->deleteImage($ad->{$field});
            }
        }

        $ad->delete();

        return response()->json(['success' => true, 'message' => 'Ad deleted successfully.']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // BULK DESTROY
    // ─────────────────────────────────────────────────────────────────────────

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        $ads = Admanager::whereIn('id', $ids)->get();

        foreach ($ads as $ad) {
            foreach (['header_ads', 'sidebar_ads', 'before_post_ads', 'after_post_ads'] as $field) {
                if ($ad->{$field . '_type'} === 'image') {
                    $this->deleteImage($ad->{$field});
                }
            }
            $ad->delete();
        }

        return response()->json(['success' => true, 'message' => 'Selected ads deleted.']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TOGGLE STATUS
    // ─────────────────────────────────────────────────────────────────────────

    public function toggleStatus(string $id)
    {
        $ad = Admanager::findOrFail($id);
        $ad->update(['status' => ! $ad->status]);

        return response()->json([
            'success' => true,
            'status'  => $ad->status,
            'message' => 'Status updated.',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Upload an image file to public/uploads/ads and return the filename.
     * Returns null if no file was uploaded.
     */
    private function uploadImage(Request $request, string $inputName): ?string
    {
        if (! $request->hasFile($inputName)) {
            return null;
        }

        $file = $request->file($inputName);

        if (! File::exists($this->uploadDir)) {
            File::makeDirectory($this->uploadDir, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($this->uploadDir, $filename);

        return $filename;
    }

    /**
     * Delete an image file from public/uploads/ads.
     */
    private function deleteImage(?string $filename): void
    {
        if (! $filename) {
            return;
        }

        $path = $this->uploadDir . '/' . basename($filename);

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
