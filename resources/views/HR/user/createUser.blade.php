@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Create New User</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 mb-6 rounded-lg border border-red-200">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Name</label>
                <input type="text" id="name" name="name" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" id="email" name="email" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input type="password" id="password" name="password" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="role_id" class="block text-gray-700 font-medium">Role <small class="text-gray-500">(Determines employee access rights)</small></label>
                <select id="role_id" name="role_id" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role_id') border-red-500 @enderror" required>
                    <option value="">Select Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="position_id" class="block text-gray-700 font-medium">Position</label>
                <select id="position_id" name="position_id" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Select Position</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                    @endforeach
                </select>
                @error('position_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium">Status</label>
                <select id="status" name="status" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="tetap" {{ old('status') == 'tetap' ? 'selected' : '' }}>Permanent Employee</option>
                    <option value="kontrak" {{ old('status') == 'kontrak' ? 'selected' : '' }}>Contract Employee</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="tanggal_join" class="block text-gray-700 font-medium">Join Date</label>
                <input type="date" id="tanggal_join" name="tanggal_join" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('tanggal_join') }}" required>
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 font-medium">Address</label>
                <textarea id="alamat" name="alamat" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="upload_ktp" class="block text-gray-700 font-medium">Upload KTP</label>
                <input type="file" id="upload_ktp" name="upload_ktp" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="emergency_call_nama" class="block text-gray-700 font-medium">Emergency Contact Name</label>
                <input type="text" id="emergency_call_nama" name="emergency_call_nama" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('emergency_call_nama') }}">
            </div>

            <div class="mb-4">
                <label for="emergency_call_nomor" class="block text-gray-700 font-medium">Emergency Contact Number</label>
                <input type="text" id="emergency_call_nomor" name="emergency_call_nomor" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('emergency_call_nomor') }}">
            </div>

            <div class="mb-4">
                <label for="jatah_cuti" class="block text-gray-700 font-medium">Leave Quota</label>
                <input type="number" id="jatah_cuti" name="jatah_cuti" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('jatah_cuti', 12) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Divisions</label>
                @foreach($divisions as $division)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="division_{{ $division->id }}" name="divisions[]" value="{{ $division->id }}" {{ in_array($division->id, old('divisions', [])) ? 'checked' : '' }} class="h-5 w-5 text-blue-600 border-gray-300 rounded">
                        <label for="division_{{ $division->id }}" class="ml-2 text-gray-700">{{ $division->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Create User</button>
        </div>
    </form>
</div>
@endsection
