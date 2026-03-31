<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Speciality;
use Illuminate\Http\Request;

class NewsspecialitycategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search  = $request->get('search');

        $specialities = Speciality::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.specialitys.index', compact('specialities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:specialities,name',
        ]);

        Speciality::create(['name' => $request->name]);

        return redirect()->route('speciality.index')
                         ->with('success', 'Speciality created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $speciality = Speciality::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:specialities,name,' . $id,
        ]);

        $speciality->update(['name' => $request->name]);

        return redirect()->route('speciality.index')
                         ->with('success', 'Speciality updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Speciality::findOrFail($id)->delete();

        return redirect()->route('speciality.index')
                         ->with('success', 'Speciality deleted successfully.');
    }

    /**
     * Bulk delete
     */
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Speciality::whereIn('id', $ids)->delete();
        }
        return redirect()->route('speciality.index')
                         ->with('success', count($ids) . ' speciality(ies) deleted.');
    }
}
