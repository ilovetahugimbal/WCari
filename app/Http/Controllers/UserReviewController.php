<?php

// app/Http/Controllers/ReviewController.php
namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Review;
use Illuminate\Http\Request;

class UserReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('reviewapp', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deskripsi_laporan' => 'required|string|max:1000',
        ]);

        Laporan::create([
            'deskripsi_laporan' => $validated['deskripsi_laporan'],
            'tanggal_laporan' => now()->format('Y-m-d'),
            'status_laporan' => 'pending', // default status
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}