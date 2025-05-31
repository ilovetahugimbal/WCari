<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToiletController extends Controller
{
    public function index()
    {
        $toilets = Toilet::with('reviews')->get();

        foreach ($toilets as $toilet) {
        $toilet->rating = round($toilet->reviews->avg('rating') ?? 0, 1);
        }

        $toilets = Toilet::with(['reviews', 'favorites' => function($query) {
        $query->where('user_id', auth()->id());
    }])->get()->map(function($toilet) {
        $toilet->is_favorite = $toilet->favorites->count() > 0;
        return $toilet;
    });

        return view('findtoilet', compact('toilets'));
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required|string',
            'description' => 'nullable|string',
            'facilities'  => 'nullable|array',
            'open'        => 'nullable',
            'close'       => 'nullable',
            'fee'         => 'nullable|string|max:50',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'contact'     => 'nullable|string|max:100',
            'access'      => 'nullable|array',
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('toilets', 'public');
        }

        // Untuk demo, hanya redirect dengan pesan sukses
        return back()->with('success', 'Data toilet berhasil dikirim!');
    }
}