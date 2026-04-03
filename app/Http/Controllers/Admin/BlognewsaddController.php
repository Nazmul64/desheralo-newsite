<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blognewsadd;
use App\Models\Newsblogcategory;
use App\Models\Newssubblogcategory;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BlognewsaddController extends Controller
{
    private string $uploadPath = 'uploads/blogadd';

    // ─── Index ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $perPage = (int) $request->get('show', 10);
        $search  = trim($request->get('search', ''));

        $news = Blognewsadd::with(['category', 'subCategory', 'speciality'])
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('title',          'like', "%{$search}%")
                       ->orWhere('summary',       'like', "%{$search}%")
                       ->orWhere('tags',          'like', "%{$search}%")
                       ->orWhere('news_reporter', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.blognewsadd.index', compact('news', 'perPage', 'search'));
    }

    // ─── Create ───────────────────────────────────────────────────────────────
    public function create()
    {
        $categories   = Newsblogcategory::active()->orderBy('sort_order')->get();
        $specialities = Speciality::orderBy('name')->get();

        return view('admin.blognewsadd.create', compact('categories', 'specialities'));
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $this->validateNews($request);

        // Featured image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $validated['status']        = (int) $request->input('status', 0);
        $validated['breaking_news'] = (int) $request->input('breaking_news', 0);

        // meta_keywords: comma-separated string → clean array
        $validated['meta_keywords'] = $this->parseKeywords($request->input('meta_keywords_input', ''));

        Blognewsadd::create($validated);

        return redirect()
            ->route('blognewsadd.index')
            ->with('success', 'নিউজ আর্টিকেল সফলভাবে তৈরি হয়েছে।');
    }

    // ─── Show ─────────────────────────────────────────────────────────────────
    public function show(string $id)
    {
        $news = Blognewsadd::with(['category', 'subCategory', 'speciality'])->findOrFail($id);
        return view('admin.blognewsadd.show', compact('news'));
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $news         = Blognewsadd::findOrFail($id);
        $categories   = Newsblogcategory::active()->orderBy('sort_order')->get();
        $specialities = Speciality::orderBy('name')->get();

        $subCategories = collect();
        if ($news->newsblogcategory_id) {
            $subCategories = Newssubblogcategory::where('newsblogcategory_id', $news->newsblogcategory_id)
                ->active()
                ->orderBy('sort_order')
                ->get();
        }

        return view('admin.blognewsadd.edit', compact('news', 'categories', 'subCategories', 'specialities'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $news      = Blognewsadd::findOrFail($id);
        $validated = $this->validateNews($request);

        if ($request->hasFile('image')) {
            $this->deleteImage($news->image);
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $validated['status']        = (int) $request->input('status', 0);
        $validated['breaking_news'] = (int) $request->input('breaking_news', 0);
        $validated['meta_keywords'] = $this->parseKeywords($request->input('meta_keywords_input', ''));

        $news->update($validated);

        return redirect()
            ->route('blognewsadd.index')
            ->with('success', 'নিউজ আর্টিকেল সফলভাবে আপডেট হয়েছে।');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────
    public function destroy(string $id)
    {
        $news = Blognewsadd::findOrFail($id);
        $this->deleteImage($news->image);
        $news->delete();

        return redirect()
            ->route('blognewsadd.index')
            ->with('success', 'নিউজ আর্টিকেল ডিলিট হয়েছে।');
    }

    // ─── Toggle Publish Status ────────────────────────────────────────────────
    public function toggleStatus(string $id)
    {
        $news = Blognewsadd::findOrFail($id);
        $news->update(['status' => ! $news->status]);

        return response()->json([
            'success' => true,
            'status'  => (int) $news->status,
            'label'   => $news->status ? 'Published' : 'Unpublished',
        ]);
    }

    // ─── Toggle Breaking News ─────────────────────────────────────────────────
    public function toggleBreaking(string $id)
    {
        $news = Blognewsadd::findOrFail($id);
        $news->update(['breaking_news' => ! $news->breaking_news]);

        return response()->json([
            'success'       => true,
            'breaking_news' => (int) $news->breaking_news,
            'label'         => $news->breaking_news ? 'Breaking' : 'Normal',
        ]);
    }

    // ─── Bulk Destroy ─────────────────────────────────────────────────────────
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer',
        ]);

        Blognewsadd::whereIn('id', $request->input('ids', []))
            ->get()
            ->each(function ($item) {
                $this->deleteImage($item->image);
                $item->delete();
            });

        return response()->json(['success' => true, 'message' => 'Selected articles deleted.']);
    }

    // ─── AJAX: Get Subcategories ──────────────────────────────────────────────
    public function getSubcategories(Request $request)
    {
        $request->validate(['category_id' => 'required|integer']);

        $subs = Newssubblogcategory::where('newsblogcategory_id', $request->category_id)
            ->active()
            ->orderBy('sort_order')
            ->get(['id', 'name']);

        return response()->json($subs);
    }

    // ─── Private: Parse Keywords ──────────────────────────────────────────────
    /**
     * "politics, bangladesh, economy" → ["politics","bangladesh","economy"]
     */
    private function parseKeywords(string $raw): array
    {
        if (trim($raw) === '') return [];

        return array_values(
            array_filter(
                array_map('trim', explode(',', $raw))
            )
        );
    }

    // ─── Private: Validate ────────────────────────────────────────────────────
    private function validateNews(Request $request): array
    {
        return $request->validate([
            'title'                  => 'required|string|max:255',
            'summary'                => 'nullable|string',
            'description'            => 'nullable|string',
            'newsblogcategory_id'    => 'nullable|exists:newsblogcategories,id',
            'newssubblogcategory_id' => 'nullable|exists:newssubblogcategories,id',
            'date'                   => 'nullable|date',
            'tags'                   => 'nullable|string|max:500',
            'speciality_id'          => 'nullable|exists:specialities,id',
            'news_reporter'          => 'nullable|string|max:255',
            'status'                 => 'nullable|in:0,1',
            'breaking_news'          => 'nullable|in:0,1',
            'image'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_keywords_input'    => 'nullable|string|max:1000',
            'meta_description'       => 'nullable|string|max:500',
        ]);
    }

    // ─── Private: Upload Image ────────────────────────────────────────────────
    private function uploadImage($file): string
    {
        $folder = public_path($this->uploadPath);
        if (! File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $filename);
        return $this->uploadPath . '/' . $filename;
    }

    // ─── Private: Delete Image ────────────────────────────────────────────────
    private function deleteImage(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
