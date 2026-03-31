<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsblogcategory;
use Illuminate\Http\Request;

class NewsblogcategoryController extends Controller
{
    // ─── Index ────────────────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $perPage = $request->input('show', 10);
        $search  = $request->input('search');

        $categories = Newsblogcategory::when(
                $search, fn($q) => $q->where('name', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.newsblogcategory.index', compact('categories', 'perPage', 'search'));
    }

    // ─── Create ───────────────────────────────────────────────────────────────
    public function create()
    {
        return view('admin.newsblogcategory.create');
    }

    // ─── Store ────────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255|unique:newsblogcategories,name',
            'status'     => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        Newsblogcategory::create([
            'name'       => $request->name,
            'status'     => $request->boolean('status', true),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return redirect()->route('newsblogcategory.index')
            ->with('success', 'Category created successfully.');
    }

    // ─── Show ─────────────────────────────────────────────────────────────────
    public function show(string $id)
    {
        $category = Newsblogcategory::findOrFail($id);
        return view('admin.newsblogcategory.show', compact('category'));
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $category = Newsblogcategory::findOrFail($id);
        return view('admin.newsblogcategory.edit', compact('category'));
    }

    // ─── Update ───────────────────────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $category = Newsblogcategory::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255|unique:newsblogcategories,name,' . $id,
            'status'     => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $category->update([
            'name'       => $request->name,
            'status'     => $request->boolean('status', true),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return redirect()->route('newsblogcategory.index')
            ->with('success', 'Category updated successfully.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────
    public function destroy(string $id)
    {
        Newsblogcategory::findOrFail($id)->delete();

        return redirect()->route('newsblogcategory.index')
            ->with('success', 'Category deleted successfully.');
    }

    // ─── Toggle Status (AJAX) ─────────────────────────────────────────────────
    public function toggleStatus(Request $request, string $id)
    {
        try {
            $category         = Newsblogcategory::findOrFail($id);
            $category->status = !$category->status;
            $category->save();

            return response()->json([
                'success' => true,
                'status'  => (bool) $category->status,
                'message' => $category->status ? 'Active' : 'Inactive',
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

        Newsblogcategory::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' item(s) deleted.',
        ]);
    }
}
