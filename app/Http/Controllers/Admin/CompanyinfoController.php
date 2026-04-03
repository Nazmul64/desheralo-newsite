<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Companyinfo;
use Illuminate\Http\Request;

class CompanyinfoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $show   = $request->input('show', 10);

        $companyinfos = Companyinfo::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate($show)
            ->withQueryString();

        return view('admin.companyinfo.index', compact('companyinfos', 'search', 'show'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        Companyinfo::create($request->only([
            'name', 'address_line1', 'address_line2',
            'phone', 'email', 'location_map',
            'message', 'copyright', 'version',
        ]) + ['status' => 1]);

        return redirect()->route('companyinfo.index')
                         ->with('success', 'Company info created successfully.');
    }

    public function edit(string $id)
    {
        $companyinfo = Companyinfo::findOrFail($id);
        return view('admin.companyinfo.edit', compact('companyinfo'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $companyinfo = Companyinfo::findOrFail($id);
        $companyinfo->update($request->only([
            'name', 'address_line1', 'address_line2',
            'phone', 'email', 'location_map',
            'message', 'copyright', 'version',
        ]));

        return redirect()->route('companyinfo.index')
                         ->with('success', 'Company info updated successfully.');
    }

    public function destroy(string $id)
    {
        Companyinfo::findOrFail($id)->delete();
        return redirect()->route('companyinfo.index')
                         ->with('success', 'Deleted successfully.');
    }

    public function toggleStatus(string $id)
    {
        $item = Companyinfo::findOrFail($id);
        $item->update(['status' => !$item->status]);
        return response()->json(['status' => $item->status]);
    }


    public function bulkDestroy(Request $request)
{
      $ids = $request->ids;

    // string হলে explode করো, array হলে সরাসরি ব্যবহার করো
    if (is_string($ids)) {
        $ids = array_filter(explode(',', $ids));
    }

    if (empty($ids)) {
        return redirect()->route('companyinfo.index')
                         ->with('error', 'No records selected.');
    }

    Companyinfo::whereIn('id', $ids)->delete();

    return redirect()->route('companyinfo.index')
                     ->with('success', 'Selected records deleted successfully.');
}
}
