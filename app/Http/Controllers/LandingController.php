<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toilet;

class LandingController extends Controller
{
    public function index()
    {
        $toilets = Toilet::all();

        // Tambahkan data dummy untuk jarak dan fasilitas (jika belum ada perhitungan jarak)
        foreach ($toilets as $toilet) {
            // Decode JSON jika perlu
            $facilities = is_array($toilet->facilities) ? $toilet->facilities : json_decode($toilet->facilities ?? '[]', true);
            $access = is_array($toilet->access) ? $toilet->access : json_decode($toilet->access ?? '[]', true);

            $toilet->distance = rand(100, 2000); // Dummy jarak dalam meter
            $toilet->has_water = in_array('Air Bersih', $facilities);
            $toilet->is_accessible = in_array('Ramah Difabel', $access);
            $toilet->has_paper = in_array('Tissue', $facilities) || in_array('Tisu', $facilities);
            //$toilet->rating = is_numeric($toilet->rating) ? floatval($toilet->rating) : 0;
            $toilet->rating = round($toilet->reviews()->avg('rating') ?? 0, 1);

            // Agar modal detail juga dapat array, bukan string
            $toilet->facilities = $facilities;
            $toilet->access = $access;
        }

        return view('layouts.app', compact('toilets'));
    }
    
    public function findToilet(Request $request)
    {
        $query = \App\Models\Toilet::query();

        //Filter nama/lokasi
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }
        
        // Filter fasilitas
        if ($request->filled('facility')) {
            $facility = $request->facility;
            if ($facility === 'water') {
                $query->whereRaw("JSON_CONTAINS(facilities, '\"Air Bersih\"')");
            } elseif ($facility === 'paper') {
                $query->where(function($q) {
                    $q->whereRaw("JSON_CONTAINS(facilities, '\"Tissue\"')")
                        ->orWhereRaw("JSON_CONTAINS(facilities, '\"Tisu\"')");
                });
            } elseif ($facility === 'accessible') {
                $query->whereRaw("JSON_CONTAINS(access, '\"Ramah Difabel\"')");
            }
        }

        $toilets = $query->get();

        // Proses fasilitas, akses, dan properti lain agar siap dipakai di Blade
        foreach ($toilets as $toilet) {
            $facilities = is_array($toilet->facilities) ? $toilet->facilities : json_decode($toilet->facilities ?? '[]', true);
            $access = is_array($toilet->access) ? $toilet->access : json_decode($toilet->access ?? '[]', true);

            $toilet->distance = rand(100, 2000); // Dummy jarak
            $toilet->has_water = in_array('Air Bersih', $facilities);
            $toilet->is_accessible = in_array('Ramah Difabel', $access);
            $toilet->has_paper = in_array('Tissue', $facilities) || in_array('Tisu', $facilities);
            //$toilet->rating = is_numeric($toilet->rating) ? floatval($toilet->rating) : 0;
            $toilet->rating = round($toilet->reviews()->avg('rating') ?? 0, 1);

            $toilet->facilities = $facilities;
            $toilet->access = $access;
        }

        return view('findtoilet', compact('toilets'));
    }

    public function findToiletAll()
    {
        $toilets = \App\Models\Toilet::all();

        // Proses fasilitas, akses, dan properti lain agar siap dipakai di Blade
        foreach ($toilets as $toilet) {
            $facilities = is_array($toilet->facilities) ? $toilet->facilities : json_decode($toilet->facilities ?? '[]', true);
            $access = is_array($toilet->access) ? $toilet->access : json_decode($toilet->access ?? '[]', true);

            $toilet->distance = rand(100, 2000); // Dummy jarak
            $toilet->has_water = in_array('Air Bersih', $facilities);
            $toilet->is_accessible = in_array('Ramah Difabel', $access);
            $toilet->has_paper = in_array('Tissue', $facilities) || in_array('Tisu', $facilities);
            //$toilet->rating = is_numeric($toilet->rating) ? floatval($toilet->rating) : 0;
            $toilet->rating = round($toilet->reviews()->avg('rating') ?? 0, 1);

            $toilet->facilities = $facilities;
            $toilet->access = $access;
        }

        return view('findtoilet_all', compact('toilets'));
    }
}
