<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newscategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Newscategory::when(request('search'), function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
        })->paginate(request('per_page', 10));

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255|unique:newscategories,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/newscategory'), $filename);
            $imagePath = 'uploads/newscategory/' . $filename;
        }

        Newscategory::create([
            'name'         => $request->name,
            'slug'         => Str::slug($request->name),
            'image'        => $imagePath,
            'menu_publish' => $request->has('menu_publish') ? 1 : 0,
        ]);

        return redirect()->route('newscategories.index')
                         ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Newscategory::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Newscategory::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255|unique:newscategories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $category->image;
        if ($request->hasFile('image')) {
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/newscategory'), $filename);
            $imagePath = 'uploads/newscategory/' . $filename;
        }

        $category->update([
            'name'         => $request->name,
            'slug'         => Str::slug($request->name),
            'image'        => $imagePath,
            'menu_publish' => $request->has('menu_publish') ? 1 : 0,
        ]);

        return redirect()->route('newscategories.index')
                         ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Newscategory::findOrFail($id);

        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }

        $category->delete();

        return redirect()->route('newscategories.index')
                         ->with('success', 'Category deleted successfully.');
    }

    /**
     * Bulk delete selected categories.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:newscategories,id',
        ]);

        $categories = Newscategory::whereIn('id', $request->ids)->get();

        foreach ($categories as $category) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $category->delete();
        }

        $count = count($request->ids);

        return redirect()->route('newscategories.index')
                         ->with('success', "{$count} " . ($count === 1 ? 'category' : 'categories') . " deleted successfully.");
    }

    /**
     * Toggle menu publish status (AJAX).
     */
    public function togglePublish(Request $request, $id)
    {
        $category = Newscategory::findOrFail($id);
        $category->update(['menu_publish' => $request->status]);

        return response()->json(['success' => true]);
    }
}
