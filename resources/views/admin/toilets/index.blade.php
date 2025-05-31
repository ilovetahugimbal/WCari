@extends('admin.layouts.app')

@section('title', 'Toilets Management')

@section('content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Toilets Management</h2>
        <a href="{{ route('admin.toilets.create') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
            Add New Toilet
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Facilities</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Accessibility</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($toilets as $toilet)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $toilet->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500">{{ $toilet->address }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if(is_string($toilet->facilities))
                                    @foreach(json_decode($toilet->facilities) ?? [] as $facility)
                                        <span class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-600">
                                            {{ $facility }}
                                        </span>
                                    @endforeach
                                @else
                                    @foreach($toilet->facilities ?? [] as $facility)
                                        <span class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-600">
                                            {{ $facility }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if(is_string($toilet->access))
                                    @foreach(json_decode($toilet->access) ?? [] as $access)
                                        <span class="px-2 py-1 text-xs rounded-full bg-emerald-50 text-emerald-600">
                                            {{ $access }}
                                        </span>
                                    @endforeach
                                @else
                                    @foreach($toilet->access ?? [] as $access)
                                        <span class="px-2 py-1 text-xs rounded-full bg-emerald-50 text-emerald-600">
                                            {{ $access }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.toilets.edit', $toilet) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form action="{{ route('admin.toilets.destroy', $toilet) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this toilet?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No toilets found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-100">
        {{ $toilets->links() }}
    </div>
</div>
@endsection