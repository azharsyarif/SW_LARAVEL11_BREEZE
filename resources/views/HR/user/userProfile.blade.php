@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Profile</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center mb-4">
            <img src="https://ui-avatars.com/api/?name={{ $user->name }}" alt="User Avatar" class="w-16 h-16 rounded-full">
            <div class="ml-4">
                <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <div class="mt-4">
            <h3 class="text-lg font-bold">Profile Information</h3>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role->name }}</p> <!-- Assuming there's a role relationship -->
            <p><strong>Join Date:</strong> {{ $user->tanggal_join }}</p>
        </div>

        <div class="mt-6">
            {{-- <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Profile</a> --}}
        </div>
    </div>
</div>
@endsection
