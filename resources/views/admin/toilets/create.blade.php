@extends('admin.layouts.app')

@section('title', 'Add New Toilet')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Add New Toilet</h2>

    <form action="{{ route('admin.toilets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <input type="text" name="address" value="{{ old('address') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Opening Time</label>
                <input type="time" name="open" value="{{ old('open') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Closing Time</label>
                <input type="time" name="close" value="{{ old('close') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>
        
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Facilities</label>
                <select name="facilities[]" multiple 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="Toilet Paper">Toilet Paper</option>
                    <option value="Hand Dryer">Hand Dryer</option>
                    <option value="Soap">Soap</option>
                    <option value="Mirror">Mirror</option>
                    <option value="Shower">Shower</option>
                    <option value="Baby Change">Baby Change</option>
                    <option value="First Aid">First Aid</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Accessibility</label>
                <select name="access[]" multiple 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="Wheelchair">Wheelchair Accessible</option>
                    <option value="Family">Family Friendly</option>
                    <option value="Gender Neutral">Gender Neutral</option>
                    <option value="Disability">Disability Access</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fee</label>
                <input type="text" name="fee" value="{{ old('fee') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contact</label>
                <input type="text" name="contact" value="{{ old('contact') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                <input type="number" step="any" name="latitude" value="{{ old('latitude') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                <input type="number" step="any" name="longitude" value="{{ old('longitude') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                <input type="file" name="photo" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.toilets') }}" 
               class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg mr-4 hover:bg-gray-200">Cancel</a>
            <button type="submit" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Create Toilet
            </button>
        </div>
    </form>
</div>
@endsection