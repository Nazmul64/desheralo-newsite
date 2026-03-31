<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NewsvideogalleryController extends Controller
{
    // ─── Upload directory (relative to public/) ───────────────────────────────
    private string $uploadDir = 'uploads/videogallery';

    // ─── Index ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $search  = $request->input('search');

        $videos = VideoGallery::when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.newsvideogallery.index', compact('videos', 'perPage', 'search'));
    }

    // ─── Create ───────────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.newsvideogallery.create');
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'video_type'  => 'required|in:upload,youtube',
            'youtube_url' => 'required_if:video_type,youtube|nullable|url',
            'video_file'  => 'required_if:video_type,upload|nullable|file|mimes:mp4,mov,avi,mkv,webm|max:204800',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $data = [
            'title'      => $request->title,
            'video_type' => $request->video_type,
            'status'     => $request->boolean('status', true),
            'sort_order' => $request->input('sort_order', 0),
        ];

        if ($request->video_type === 'youtube') {
            $data['youtube_url'] = $request->youtube_url;
        } else {
            $data['video_path'] = $this->uploadFile($request->file('video_file'), $this->uploadDir);
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadFile($request->file('thumbnail'), $this->uploadDir . '/thumbnails');
        }

        VideoGallery::create($data);

        return redirect()->route('newsvideogallery.index')
            ->with('success', 'Video gallery item created successfully.');
    }

    // ─── Show ─────────────────────────────────────────────────────────────────
    public function show(string $id)
    {
        $video = VideoGallery::findOrFail($id);
        return view('admin.newsvideogallery.show', compact('video'));
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $video = VideoGallery::findOrFail($id);
        return view('admin.newsvideogallery.edit', compact('video'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $video = VideoGallery::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'video_type'  => 'required|in:upload,youtube',
            'youtube_url' => 'required_if:video_type,youtube|nullable|url',
            'video_file'  => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:204800',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $data = [
            'title'      => $request->title,
            'video_type' => $request->video_type,
            'status'     => $request->boolean('status', true),
            'sort_order' => $request->input('sort_order', 0),
        ];

        if ($request->video_type === 'youtube') {
            if ($video->video_path) $this->deleteFile($video->video_path);
            $data['youtube_url'] = $request->youtube_url;
            $data['video_path']  = null;
        } else {
            $data['youtube_url'] = null;
            if ($request->hasFile('video_file')) {
                if ($video->video_path) $this->deleteFile($video->video_path);
                $data['video_path'] = $this->uploadFile($request->file('video_file'), $this->uploadDir);
            }
        }

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) $this->deleteFile($video->thumbnail);
            $data['thumbnail'] = $this->uploadFile($request->file('thumbnail'), $this->uploadDir . '/thumbnails');
        }

        $video->update($data);

        return redirect()->route('newsvideogallery.index')
            ->with('success', 'Video gallery item updated successfully.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────
    public function destroy(string $id)
    {
        $video = VideoGallery::findOrFail($id);

        if ($video->video_path) $this->deleteFile($video->video_path);
        if ($video->thumbnail)  $this->deleteFile($video->thumbnail);

        $video->delete();

        return redirect()->route('newsvideogallery.index')
            ->with('success', 'Video gallery item deleted successfully.');
    }

    // ─── Toggle Status (AJAX) ─────────────────────────────────────────────────
    public function toggleStatus(Request $request, string $id)
    {
        try {
            $video         = VideoGallery::findOrFail($id);
            $video->status = !$video->status;
            $video->save();

            return response()->json([
                'success' => true,
                'status'  => (bool) $video->status,
                'message' => $video->status ? 'Published' : 'Unpublished',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 500);
        }
    }

    // ─── Bulk Destroy ─────────────────────────────────────────────────────────
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer',
        ]);

        $videos = VideoGallery::whereIn('id', $request->ids)->get();

        foreach ($videos as $video) {
            if ($video->video_path) $this->deleteFile($video->video_path);
            if ($video->thumbnail)  $this->deleteFile($video->thumbnail);
            $video->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' item(s) deleted.',
        ]);
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────
    private function uploadFile($file, string $dir): string
    {
        $publicDir = public_path($dir);

        if (!File::exists($publicDir)) {
            File::makeDirectory($publicDir, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($publicDir, $filename);

        return $dir . '/' . $filename;
    }

    private function deleteFile(string $path): void
    {
        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
