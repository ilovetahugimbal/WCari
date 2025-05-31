@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-semibold mb-6">Login</h2>
        @if($errors->any())
            <div class="mb-4 text-red-600">{{ $errors->first('login') }}</div>
        @endif
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block mb-2 text-sm font-semibold" for="email">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-semibold" for="password">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg">Login</button>
        </form>
    </div>
</div>
@endsection