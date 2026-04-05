<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Themecolor;
use Illuminate\Http\Request;

class ThemecolorController extends Controller
{
    // ── Index ────────────────────────────────────────────────
    public function index()
    {
        $themecolors = Themecolor::latest()->paginate(10);
        return view('admin.themecolor.index', compact('themecolors'));
    }

    // ── Create ───────────────────────────────────────────────
    public function create()
    {
        return view('admin.themecolor.create');
    }

    // ── Store ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:100|unique:themecolors,name',
            'primary_color'    => 'required|string|max:7',
            'secondary_color'  => 'required|string|max:7',
            'accent_color'     => 'nullable|string|max:7',
            'background_color' => 'required|string|max:7',
            'text_color'       => 'required|string|max:7',
            'description'      => 'nullable|string|max:500',
        ]);

        // ✅ checkbox: present=1, absent=0
        $isDefault = $request->boolean('is_default'); // true/false
        $status    = $request->boolean('status');     // true/false

        // যদি নতুনটা default হয়, আগেরটা সরাও
        if ($isDefault) {
            Themecolor::where('is_default', true)->update(['is_default' => false]);
        }

        // ✅ সরাসরি array বানাও, $validated এর উপর নির্ভর না করে
        Themecolor::create([
            'name'             => $request->name,
            'primary_color'    => $request->primary_color,
            'secondary_color'  => $request->secondary_color,
            'accent_color'     => $request->accent_color,
            'background_color' => $request->background_color,
            'text_color'       => $request->text_color,
            'description'      => $request->description,
            'is_default'       => $isDefault,
            'status'           => $status,
        ]);

        return redirect()
            ->route('themecolor.index')
            ->with('success', 'Theme color created successfully!');
    }

    // ── Show ─────────────────────────────────────────────────
    public function show(string $id)
    {
        $themecolor = Themecolor::findOrFail($id);
        return view('admin.themecolor.show', compact('themecolor'));
    }

    // ── Edit ─────────────────────────────────────────────────
    public function edit(string $id)
    {
        $themecolor = Themecolor::findOrFail($id);
        return view('admin.themecolor.edit', compact('themecolor'));
    }

    // ── Update ───────────────────────────────────────────────
    public function update(Request $request, string $id)
    {
        $themecolor = Themecolor::findOrFail($id);

        $request->validate([
            'name'             => 'required|string|max:100|unique:themecolors,name,' . $id,
            'primary_color'    => 'required|string|max:7',
            'secondary_color'  => 'required|string|max:7',
            'accent_color'     => 'nullable|string|max:7',
            'background_color' => 'required|string|max:7',
            'text_color'       => 'required|string|max:7',
            'description'      => 'nullable|string|max:500',
        ]);

        $isDefault = $request->boolean('is_default');
        $status    = $request->boolean('status');

        if ($isDefault) {
            Themecolor::where('is_default', true)
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $themecolor->update([
            'name'             => $request->name,
            'primary_color'    => $request->primary_color,
            'secondary_color'  => $request->secondary_color,
            'accent_color'     => $request->accent_color,
            'background_color' => $request->background_color,
            'text_color'       => $request->text_color,
            'description'      => $request->description,
            'is_default'       => $isDefault,
            'status'           => $status,
        ]);

        return redirect()
            ->route('themecolor.index')
            ->with('success', 'Theme color updated successfully!');
    }

    // ── Destroy ──────────────────────────────────────────────
    public function destroy(string $id)
    {
        Themecolor::findOrFail($id)->delete();

        return redirect()
            ->route('themecolor.index')
            ->with('success', 'Theme color deleted successfully!');
    }

    // ── Toggle Status ────────────────────────────────────────
    public function toggleStatus(string $id)
    {
        $themecolor = Themecolor::findOrFail($id);
        $themecolor->update(['status' => !$themecolor->status]);

        return response()->json([
            'success' => true,
            'status'  => $themecolor->status,
            'message' => 'Status updated successfully!',
        ]);
    }

    // ── Bulk Destroy ─────────────────────────────────────────
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:themecolors,id',
        ]);

        Themecolor::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' theme color(s) deleted!',
        ]);
    }
}
