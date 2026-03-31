<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsSubcategory;
use App\Models\Newscategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsSubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = NewsSubcategory::with('category')
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%");
            })
            ->paginate(request('per_page', 10));

        // Categories needed for the create/edit modal on the index page
        $categories = Newscategory::orderBy('name')->get();

        return view('admin.newsubcategory.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'newscategory_id' => 'required|exists:newscategories,id',
            'name'            => 'required|string|max:255|unique:news_subcategories,name',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/newssubcategory'), $filename);
            $imagePath = 'uploads/newssubcategory/' . $filename;
        }

        NewsSubcategory::create([
            'newscategory_id' => $request->newscategory_id,
            'name'            => $request->name,
            'slug'            => Str::slug($request->name),
            'image'           => $imagePath,
            'menu_publish'    => $request->has('menu_publish') ? 1 : 0,
        ]);

        return redirect()->route('newssubcategories.index')
                         ->with('success', 'Subcategory created successfully.');
    }

    public function update(Request $request, $id)
    {
        $subcategory = NewsSubcategory::findOrFail($id);

        $request->validate([
            'newscategory_id' => 'required|exists:newscategories,id',
            'name'            => 'required|string|max:255|unique:news_subcategories,name,' . $subcategory->id,
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $subcategory->image;
        if ($request->hasFile('image')) {
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            $file     = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/newssubcategory'), $filename);
            $imagePath = 'uploads/newssubcategory/' . $filename;
        }

        $subcategory->update([
            'newscategory_id' => $request->newscategory_id,
            'name'            => $request->name,
            'slug'            => Str::slug($request->name),
            'image'           => $imagePath,
            'menu_publish'    => $request->has('menu_publish') ? 1 : 0,
        ]);

        return redirect()->route('newssubcategories.index')
                         ->with('success', 'Subcategory updated successfully.');
    }

    public function destroy($id)
    {
        $subcategory = NewsSubcategory::findOrFail($id);

        if ($subcategory->image && file_exists(public_path($subcategory->image))) {
            unlink(public_path($subcategory->image));
        }

        $subcategory->delete();

        return redirect()->route('newssubcategories.index')
                         ->with('success', 'Subcategory deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:news_subcategories,id',
        ]);

        $subcategories = NewsSubcategory::whereIn('id', $request->ids)->get();

        foreach ($subcategories as $subcategory) {
            if ($subcategory->image && file_exists(public_path($subcategory->image))) {
                unlink(public_path($subcategory->image));
            }
            $subcategory->delete();
        }

        $count = count($request->ids);

        return redirect()->route('newssubcategories.index')
                         ->with('success', "{$count} " . ($count === 1 ? 'subcategory' : 'subcategories') . " deleted successfully.");
    }

    public function togglePublish(Request $request, $id)
    {
        $subcategory = NewsSubcategory::findOrFail($id);
        $subcategory->update(['menu_publish' => $request->status]);

        return response()->json(['success' => true]);
    }
}
