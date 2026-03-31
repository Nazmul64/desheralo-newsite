<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsblogcategory;
use App\Models\Newssubblogcategory;
use Illuminate\Http\Request;

class NewsblogsubcategoryController extends Controller
{
    // ─── Index ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $search  = $request->input('search');

        $subcategories = Newssubblogcategory::with('category')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.newsblogsubcategory.index', compact('subcategories', 'perPage', 'search'));
    }

    // ─── Create ───────────────────────────────────────────────────────────────
    public function create()
    {
        $categories = Newsblogcategory::orderBy('name')->get();
        return view('admin.newsblogsubcategory.create', compact('categories'));
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'newsblogcategory_id' => 'required|exists:newsblogcategories,id',
            'name'                => 'required|string|max:255',
            'status'              => 'nullable|boolean',
            'sort_order'          => 'nullable|integer|min:0',
        ]);

        Newssubblogcategory::create([
            'newsblogcategory_id' => $validated['newsblogcategory_id'],
            'name'                => $validated['name'],
            'status'              => $request->boolean('status', true),
            'sort_order'          => $request->input('sort_order', 0),
        ]);

        return redirect()->route('newsblogsubcategory.index')
            ->with('success', 'Sub-category created successfully.');
    }

    // ─── Show ─────────────────────────────────────────────────────────────────
    public function show(string $id)
    {
        $subcategory = Newssubblogcategory::with('category')->findOrFail($id);
        return view('admin.newsblogsubcategory.show', compact('subcategory'));
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $subcategory = Newssubblogcategory::findOrFail($id);   // ✅ FIX
        $categories  = Newsblogcategory::orderBy('name')->get();

        return view('admin.newsblogsubcategory.edit', compact('subcategory', 'categories'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $subcategory = Newssubblogcategory::findOrFail($id);

        $validated = $request->validate([
            'newsblogcategory_id' => 'required|exists:newsblogcategories,id',
            'name'                => 'required|string|max:255',
            'status'              => 'nullable|boolean',
            'sort_order'          => 'nullable|integer|min:0',
        ]);

        $subcategory->update([
            'newsblogcategory_id' => $validated['newsblogcategory_id'],
            'name'                => $validated['name'],
            'status'              => $request->boolean('status', true),
            'sort_order'          => $request->input('sort_order', 0),
        ]);

        return redirect()->route('newsblogsubcategory.index')
            ->with('success', 'Sub-category updated successfully.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────
    public function destroy(string $id)
    {
        Newssubblogcategory::findOrFail($id)->delete();

        return redirect()->route('newsblogsubcategory.index')
            ->with('success', 'Sub-category deleted successfully.');
    }

    // ─── Toggle Status (AJAX) ─────────────────────────────────────────────────
    public function toggleStatus(Request $request, string $id)
    {
        try {
            $sub         = Newssubblogcategory::findOrFail($id);
            $sub->status = !$sub->status;
            $sub->save();

            return response()->json([
                'success' => true,
                'status'  => (bool) $sub->status,
                'message' => $sub->status ? 'Active' : 'Inactive',
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

        Newssubblogcategory::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' item(s) deleted.',
        ]);
    }
}
