<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderCode;
use Illuminate\Http\Request;

class HeaderCodeController extends Controller
{
    public function index()
    {
        $headers = HeaderCode::latest()->get();
        return view('admin.headercode.index', compact('headers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'google_analytics' => 'required|string',
        ]);

        HeaderCode::create([
            'google_analytics' => $request->google_analytics,
            'status'           => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Header code saved successfully.']);
    }

    public function update(Request $request, string $id)
    {
        $header = HeaderCode::findOrFail($id);

        $request->validate([
            'google_analytics' => 'required|string',
        ]);

        $header->update([
            'google_analytics' => $request->google_analytics,
        ]);

        return response()->json(['success' => true, 'message' => 'Header code updated successfully.']);
    }

    public function destroy(string $id)
    {
        HeaderCode::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Header code deleted.']);
    }

    public function bulkDestroy(Request $request)
    {
        HeaderCode::whereIn('id', $request->input('ids', []))->delete();
        return response()->json(['success' => true, 'message' => 'Selected items deleted.']);
    }

    public function toggleStatus(string $id)
    {
        $header = HeaderCode::findOrFail($id);
        $header->update(['status' => ! $header->status]);

        return response()->json(['success' => true, 'status' => $header->status]);
    }
}
