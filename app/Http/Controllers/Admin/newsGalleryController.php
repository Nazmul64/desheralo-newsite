<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class newsGalleryController extends Controller
{
    /* ── Index ─────────────────────────────────────── */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search');

        $galleries = Gallery::query()
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.newsgallery.index', compact('galleries'));
    }

    /* ── Create form ───────────────────────────────── */
    public function create()
    {
        return view('admin.newsgallery.create');
    }

    /* ── Store ─────────────────────────────────────── */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('photo')) {
            $file      = $request->file('photo');
            $fileName  = time() . '.' . $file->getClientOriginalExtension();
            $uploadDir = public_path('uploads/newsgallery');

            // folder create if not exists
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $file->move($uploadDir, $fileName);

            $path = 'uploads/newsgallery/' . $fileName;
        }

        Gallery::create([
            'title'  => $request->title,
            'photo'  => $path,
            'status' => 1, // always active
        ]);

        return redirect()->route('newsgallery.index')
                         ->with('success', 'Gallery item created successfully.');
    }

    /* ── Edit form ─────────────────────────────────── */
    public function edit(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.newsgallery.edit', compact('gallery'));
    }

    /* ── Update ────────────────────────────────────── */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $data = [
            'title'  => $request->title,
            'status' => 1,
        ];

        if ($request->hasFile('photo')) {

            // delete old photo
            if ($gallery->photo && File::exists(public_path($gallery->photo))) {
                File::delete(public_path($gallery->photo));
            }

            $file      = $request->file('photo');
            $fileName  = time() . '.' . $file->getClientOriginalExtension();
            $uploadDir = public_path('uploads/newsgallery');

            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $file->move($uploadDir, $fileName);

            $data['photo'] = 'uploads/newsgallery/' . $fileName;
        }

        $gallery->update($data);

        return redirect()->route('newsgallery.index')
                         ->with('success', 'Gallery item updated successfully.');
    }

    /* ── Destroy ───────────────────────────────────── */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->photo && File::exists(public_path($gallery->photo))) {
            File::delete(public_path($gallery->photo));
        }

        $gallery->delete();

        return redirect()->route('newsgallery.index')
                         ->with('success', 'Gallery item deleted successfully.');
    }

    /* ── Bulk destroy ──────────────────────────────── */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            $items = Gallery::whereIn('id', $ids)->get();

            foreach ($items as $item) {
                if ($item->photo && File::exists(public_path($item->photo))) {
                    File::delete(public_path($item->photo));
                }
                $item->delete();
            }
        }

        return redirect()->route('newsgallery.index')
                         ->with('success', count($ids) . ' item(s) deleted successfully.');
    }
}
