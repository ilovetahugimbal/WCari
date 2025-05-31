<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class ReportController extends Controller
{
    public function index()
    {
        // Fetch all reports with their associated toilet and user (if user relation exists)
        // Adjust the 'user' withAuth if you add a user_id to laporans
        $reports = Laporan::with(['toilet'])
                           ->where('soft_delete', false) // Filter out soft-deleted reports
                           ->latest() // Order by latest reports first
                           ->get();

        return view('report', compact('reports'));
    }

    public function show($id)
    {
        $report = Laporan::with(['toilet'])->findOrFail($id);
        return view('report_detail', compact('report')); // Create a report_detail.blade.php for this
    }
}