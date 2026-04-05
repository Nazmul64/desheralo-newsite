<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cmsheader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CmsheaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('show', 10);
        $search  = $request->get('search');

        $cmsheaders = Cmsheader::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.cmsheader.index', compact('cmsheaders', 'perPage', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cmsheader.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cmsheader'), $filename);
            $imagePath = 'uploads/cmsheader/' . $filename;
        }

        Cmsheader::create([
            'name'   => $request->name,
            'image'  => $imagePath,
            'status' => 1,
        ]);

        return redirect()->route('cmsheader.index')->with('success', 'Header created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cmsheader = Cmsheader::findOrFail($id);
        return view('admin.cmsheader.edit', compact('cmsheader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cmsheader = Cmsheader::findOrFail($id);

        $request->validate([
            'name'  => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
        ]);

        $imagePath = $cmsheader->image;
        if ($request->hasFile('image')) {
            // Delete old image
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            $file      = $request->file('image');
            $filename  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cmsheader'), $filename);
            $imagePath = 'uploads/cmsheader/' . $filename;
        }

        $cmsheader->update([
            'name'  => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('cmsheader.index')->with('success', 'Header updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cmsheader = Cmsheader::findOrFail($id);

        if ($cmsheader->image && file_exists(public_path($cmsheader->image))) {
            unlink(public_path($cmsheader->image));
        }

        $cmsheader->delete();

        return redirect()->route('cmsheader.index')->with('success', 'Header deleted successfully.');
    }

    /**
     * Toggle is_active status.
     */
    public function toggleStatus(Request $request, string $id)
    {
        $cmsheader =Cmsheader::findOrFail($id);
        $field     = $request->get('field', 'status');
        $cmsheader->$field = !$cmsheader->$field;
        $cmsheader->save();

        return response()->json(['success' => true, 'value' => $cmsheader->$field]);
    }

    /**
     * Bulk delete.
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $headers = Cmsheader::whereIn('id', $ids)->get();
            foreach ($headers as $header) {
                if ($header->image && file_exists(public_path($header->image))) {
                    unlink(public_path($header->image));
                }
                $header->delete();
            }
        }
        return response()->json(['success' => true]);
    }
}
