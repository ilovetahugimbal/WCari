@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Reports Overview</h2>
        <div class="grid grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-500">{{ $pendingCount ?? 0 }}</div>
                <div class="text-sm text-gray-500">Pending</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-500">{{ $processedCount ?? 0 }}</div>
                <div class="text-sm text-gray-500">Processed</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-500">{{ $resolvedCount ?? 0 }}</div>
                <div class="text-sm text-gray-500">Resolved</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Toilets Overview</h2>
        <div class="text-3xl font-bold text-indigo-600">{{ $toiletsCount ?? 0 }}</div>
        <div class="text-sm text-gray-500">Total Toilets</div>
    </div>
</div>
@endsection