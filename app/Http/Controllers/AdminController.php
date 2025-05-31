<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Toilet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung total toilet
        $toiletsCount = Toilet::count();

        // Hitung laporan berdasarkan status
        $pendingCount = Laporan::where('status_laporan', 'pending')->count();
        $processedCount = Laporan::where('status_laporan', 'processed')->count();
        $resolvedCount = Laporan::where('status_laporan', 'resolved')->count();

        return view('admin.dashboard', compact(
            'toiletsCount',
            'pendingCount',
            'processedCount',
            'resolvedCount'
        ));
    }

    public function laporans()
    {
        $laporans = Laporan::latest()->paginate(10);
        return view('admin.laporans.index', compact('laporans'));
    }

    public function toilets()
{
        $toilets = Toilet::latest()->paginate(10);
        return view('admin.toilets.index', compact('toilets'));
    }
public function createToilet()
{
    return view('admin.toilets.create');
}

public function storeToilet(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'description' => 'nullable|string',
        'facilities' => 'nullable|array',
        'facilities.*' => 'string',
        'open' => 'nullable|string',
        'close' => 'nullable|string',
        'fee' => 'nullable|string',
        'photo' => 'nullable|image|max:2048',
        'contact' => 'nullable|string',
        'access' => 'nullable|array',
        'access.*' => 'string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('toilets', 'public');
    }

    Toilet::create($validated);

    return redirect()->route('admin.toilets')->with('success', 'Toilet created successfully');
}

public function editToilet(Toilet $toilet)
{
    return view('admin.toilets.edit', compact('toilet'));
}

public function updateToilet(Request $request, Toilet $toilet)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'description' => 'nullable|string',
        'facilities' => 'nullable|array',
        'facilities.*' => 'string',
        'open' => 'nullable|string',
        'close' => 'nullable|string',
        'fee' => 'nullable|string',
        'photo' => 'nullable|image|max:2048',
        'contact' => 'nullable|string',
        'access' => 'nullable|array',
        'access.*' => 'string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    if ($request->hasFile('photo')) {
        if ($toilet->photo) {
            Storage::disk('public')->delete($toilet->photo);
        }
        $validated['photo'] = $request->file('photo')->store('toilets', 'public');
    }

    $toilet->update($validated);

    return redirect()->route('admin.toilets')->with('success', 'Toilet updated successfully');
}

public function destroyToilet(Toilet $toilet)
{
    if ($toilet->photo) {
        Storage::disk('public')->delete($toilet->photo);
    }
    
    $toilet->delete();

        return redirect()->route('admin.toilets')->with('success', 'Toilet deleted successfully');
    }

    public function updateLaporan(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'status_laporan' => 'required|in:pending,processed,resolved',
        ]);

        $laporan->update($validated);
        return redirect()->route('admin.laporans')->with('success', 'Report status updated');
    }
}