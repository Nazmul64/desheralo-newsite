<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newblog;
use App\Models\Newsblogcategory;
use App\Models\Newssubblogcategory;
use Illuminate\Http\Request;

class NewblogController extends Controller
{
    // ─── Index ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $search  = $request->input('search');

        $blogs = Newblog::with(['category', 'subCategory'])
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.newsblog.index', compact('blogs', 'perPage', 'search'));
    }

    // ─── Create ───────────────────────────────────────────────────────────────
    public function create()
    {
        $categories    = Newsblogcategory::orderBy('name')->get();
        $subcategories = Newssubblogcategory::orderBy('name')->get();
        return view('admin.newsblog.create', compact('categories', 'subcategories'));
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'title'                  => 'required|string|max:255',
            'summary'                => 'nullable|string',
            'description'            => 'nullable|string',
            'newsblogcategory_id'    => 'nullable|exists:newsblogcategories,id',
            'newssubblogcategory_id' => 'nullable|exists:newssubblogcategories,id',
            'tags'                   => 'nullable|string|max:500',
            'date'                   => 'nullable|date',
            'status'                 => 'nullable|in:0,1',
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'));
        }

        Newblog::create([
            'title'                  => $request->title,
            'summary'                => $request->summary,
            'description'            => $request->description,
            'newsblogcategory_id'    => $request->newsblogcategory_id,
            'newssubblogcategory_id' => $request->newssubblogcategory_id,
            'tags'                   => $request->tags,
            'date'                   => $request->date,
            'status'                 => $request->input('status', 1),
            'image'                  => $imagePath,
        ]);

        return redirect()->route('newblog.index')
            ->with('success', 'Blog created successfully.');
    }

    // ─── Show ─────────────────────────────────────────────────────────────────
    public function show(string $id)
    {
        $blog = Newblog::with(['category', 'subCategory'])->findOrFail($id);
        return view('admin.newsblog.show', compact('blog'));
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $blog          = Newblog::findOrFail($id);
        $categories    = Newsblogcategory::orderBy('name')->get();
        $subcategories = Newssubblogcategory::orderBy('name')->get();
        return view('admin.newsblog.edit', compact('blog', 'categories', 'subcategories'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $blog = Newblog::findOrFail($id);

        $request->validate([
            'title'                  => 'required|string|max:255',
            'summary'                => 'nullable|string',
            'description'            => 'nullable|string',
            'newsblogcategory_id'    => 'nullable|exists:newsblogcategories,id',
            'newssubblogcategory_id' => 'nullable|exists:newssubblogcategories,id',
            'tags'                   => 'nullable|string|max:500',
            'date'                   => 'nullable|date',
            'status'                 => 'nullable|in:0,1',
            'image'                  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = $blog->image;
        if ($request->hasFile('image')) {
            // পুরনো ছবি delete করো
            $this->deleteImage($blog->image);
            // নতুন ছবি upload করো
            $imagePath = $this->uploadImage($request->file('image'));
        }

        $blog->update([
            'title'                  => $request->title,
            'summary'                => $request->summary,
            'description'            => $request->description,
            'newsblogcategory_id'    => $request->newsblogcategory_id,
            'newssubblogcategory_id' => $request->newssubblogcategory_id,
            'tags'                   => $request->tags,
            'date'                   => $request->date,
            'status'                 => $request->input('status', $blog->status),
            'image'                  => $imagePath,
        ]);

        return redirect()->route('newblog.index')
            ->with('success', 'Blog updated successfully.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────
    public function destroy(string $id)
    {
        $blog = Newblog::findOrFail($id);

        $this->deleteImage($blog->image);
        $blog->delete();

        return redirect()->route('newblog.index')
            ->with('success', 'Blog deleted successfully.');
    }

    // ─── Toggle Status (AJAX) ─────────────────────────────────────────────────
    public function toggleStatus(string $id)
    {
        try {
            $blog         = Newblog::findOrFail($id);
            $blog->status = !$blog->status;
            $blog->save();

            return response()->json([
                'success' => true,
                'status'  => (bool) $blog->status,
                'message' => $blog->status ? 'Published' : 'Unpublished',
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

        $blogs = Newblog::whereIn('id', $request->ids)->get();
        foreach ($blogs as $blog) {
            $this->deleteImage($blog->image);
            $blog->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' blog(s) deleted.',
        ]);
    }

    // ─── Get Subcategories by Category (AJAX) ────────────────────────────────
    public function getSubcategories(Request $request)
    {
        $subcategories = Newssubblogcategory::where('newsblogcategory_id', $request->category_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }

    // ─── Private Helpers ──────────────────────────────────────────────────────

    /**
     * Image upload → public/uploads/blog/
     * DB তে save হবে: uploads/blog/filename.jpg
     */
    private function uploadImage($file): string
    {
        $uploadDir = public_path('uploads/blog');

        // ফোল্ডার না থাকলে তৈরি করো
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadDir, $fileName);

        return 'uploads/blog/' . $fileName;
    }

    /**
     * Image delete from public/uploads/blog/
     */
    private function deleteImage(?string $imagePath): void
    {
        if (!$imagePath) return;

        $fullPath = public_path($imagePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
