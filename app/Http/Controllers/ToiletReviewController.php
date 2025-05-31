<?php

namespace App\Http\Controllers;

use App\Models\Toilet;
use App\Models\Review;
use Illuminate\Http\Request;

class ToiletReviewController extends Controller
{
    // Tampilkan halaman review untuk toilet tertentu
    public function show($id)
    {
        $toilet = Toilet::find($id);
        if (!$toilet) {
            abort(404, 'Toilet tidak ditemukan');
        }
        $reviews = $toilet->reviews()->latest()->get();
        $images = is_array($toilet->images) ? $toilet->images : json_decode($toilet->images, true) ?? ['images/toilet1.jpg', 'images/toilet2.jpg'];

        // Hitung rata-rata rating dari reviews
        $averageRating = $toilet->reviews()->avg('rating') ?? 0;
        $toilet->rating = $averageRating;

        return view('review', compact('toilet', 'reviews', 'images'));
    }

    // Simpan review baru
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Review::create([
            'toilet_id' => $id,
            'komentar' => $request->input('content'),
            'tanggal_review' => now()->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
            'rating' => $request->input('rating', 0), // Default rating to 0 if not provided
        ]);

        return redirect()->route('toilet.review.show', $id)->with('success', 'Ulasan berhasil dikirim!');
    }
}