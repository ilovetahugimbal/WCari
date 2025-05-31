@extends('admin.layouts.app')

@section('title', 'Edit Toilet')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Toilet</h2>

    <form action="{{ route('admin.toilets.update', $toilet) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $toilet->name) }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <input type="text" name="address" value="{{ old('address', $toilet->address) }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">{{ old('description', $toilet->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Opening Time</label>
                <input type="time" name="open" value="{{ old('open', $toilet->open) }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Closing Time</label>
                <input type="time" name="close" value="{{ old('close', $toilet->close) }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Facilities</label>
                <select name="facilities[]" multiple 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="Toilet Paper" @if(in_array('Toilet Paper', $toilet->facilities ?? [])) selected @endif>Toilet Paper</option>
                    <option value="Hand Dryer" @if(in_array('Hand Dryer', $toilet->facilities ?? [])) selected @endif>Hand Dryer</option>
                    <option value="Soap" @if(in_array('Soap', $toilet->facilities ?? [])) selected @endif>Soap</option>
                    <option value="Mirror" @if(in_array('Mirror', $toilet->facilities ?? [])) selected @endif>Mirror</option>
                    <option value="Shower" @if(in_array('Shower', $toilet->facilities ?? [])) selected @endif>Shower</option>
                    <option value="Baby Change" @if(in_array('Baby Change', $toilet->facilities ?? [])) selected @endif>Baby Change</option>
                    <option value="First Aid" @if(in_array('First Aid', $toilet->facilities ?? [])) selected @endif>First Aid</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Accessibility</label>
                <select name="access[]" multiple 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="Wheelchair" @if(in_array('Wheelchair', $toilet->access ?? [])) selected @endif>Wheelchair Accessible</option>
                    <option value="Family" @if(in_array('Family', $toilet->access ?? [])) selected @endif>Family Friendly</option>
                    <option value="Gender Neutral" @if(in_array('Gender Neutral', $toilet->access ?? [])) selected @endif>Gender Neutral</option>
                    <option value="Disability" @if(in_array('Disability', $toilet->access ?? [])) selected @endif>Disability Access</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Fee</label>
                <input type="text" name="fee" value="{{ old('fee', $toilet->fee) }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contact</label>
                <input type="text" name="contact" value="{{ old('contact', $toilet->contact) }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                <input type="file" name="photo" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                @if($toilet->photo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $toilet->photo) }}" alt="Current photo" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.toilets') }}" 
               class="bg-gray-100 text-gray-800 px-4 py-2 rounded-lg mr-4 hover:bg-gray-200">Cancel</a>
            <button type="submit" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Update Toilet
            </button>
        </div>
    </form>
</div>
@endsection