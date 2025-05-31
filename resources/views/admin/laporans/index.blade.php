@extends('admin.layouts.app')

@section('title', 'Reports Management')

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800">Reports Management</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($laporans as $laporan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $laporan->id }}</td>
                        <td class="px-6 py-4 text-sm">{{ $laporan->deskripsi_laporan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.laporans.update', $laporan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status_laporan" onchange="this.form.submit()" 
                                        class="rounded-md text-sm border-gray-300 focus:border-indigo-500">
                                    <option value="pending" {{ $laporan->status_laporan == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="processed" {{ $laporan->status_laporan == 'processed' ? 'selected' : '' }}>
                                        Processed
                                    </option>
                                    <option value="resolved" {{ $laporan->status_laporan == 'resolved' ? 'selected' : '' }}>
                                        Resolved
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $laporan->tanggal_laporan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-indigo-600 hover:text-indigo-900">View Details</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No reports found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $laporans->links() }}
    </div>
</div>
@endsection