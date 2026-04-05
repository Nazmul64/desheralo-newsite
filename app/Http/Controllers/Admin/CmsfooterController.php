<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cmsfooter;
use Illuminate\Http\Request;

class CmsfooterController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('show', 10);
        $search  = $request->get('search');

        $cmsFooters = Cmsfooter::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.cmsfooter.index', compact('cmsFooters', 'perPage', 'search'));
    }

    public function create()
    {
        return view('admin.cmsfooter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cmsfooter'), $filename);
            $imagePath = 'uploads/cmsfooter/' . $filename;
        }

        Cmsfooter::create([
            'name'   => $request->name,
            'image'  => $imagePath,
            'status' => 1,
        ]);

        return redirect()->route('cmsfooter.index')->with('success', 'Footer created successfully.');
    }

    public function edit(string $id)
    {
        $cmsfooter = Cmsfooter::findOrFail($id);
        return view('admin.cmsfooter.edit', compact('cmsfooter'));
    }

    public function update(Request $request, string $id)
    {
        $cmsfooter = Cmsfooter::findOrFail($id);

        $request->validate([
            'name'  => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $imagePath = $cmsfooter->image;
        if ($request->hasFile('image')) {
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            $file      = $request->file('image');
            $filename  = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cmsfooter'), $filename);
            $imagePath = 'uploads/cmsfooter/' . $filename;
        }

        $cmsfooter->update([
            'name'  => $request->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('cmsfooter.index')->with('success', 'Footer updated successfully.');
    }

    public function destroy(string $id)
    {
        $cmsfooter = Cmsfooter::findOrFail($id);

        if ($cmsfooter->image && file_exists(public_path($cmsfooter->image))) {
            unlink(public_path($cmsfooter->image));
        }

        $cmsfooter->delete();

        return redirect()->route('cmsfooter.index')->with('success', 'Footer deleted successfully.');
    }

    public function toggleStatus(Request $request, string $id)
    {
        $cmsfooter         = Cmsfooter::findOrFail($id);
        $field             = $request->get('field', 'status');
        $cmsfooter->$field = !$cmsfooter->$field;
        $cmsfooter->save();

        return response()->json(['success' => true, 'value' => $cmsfooter->$field]);
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $footers = Cmsfooter::whereIn('id', explode(',', $ids))->get();
            foreach ($footers as $footer) {
                if ($footer->image && file_exists(public_path($footer->image))) {
                    unlink(public_path($footer->image));
                }
                $footer->delete();
            }
        }
        return response()->json(['success' => true]);
    }
}
