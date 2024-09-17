@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">{{ __('Edit User') }}</h1>

        <!-- Form Edit User -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role_id" class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                    <select name="role_id" id="role_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $role->id == old('role_id', $user->role_id) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position -->
                <div class="mb-4">
                    <label for="position_id" class="block text-sm font-medium text-gray-700">{{ __('Position') }}</label>
                    <select name="position_id" id="position_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ $position->id == old('position_id', $user->position_id) ? 'selected' : '' }}>{{ $position->name }}</option>
                        @endforeach
                    </select>
                    @error('position_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                    <input type="text" name="status" id="status" value="{{ old('status', $user->status) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">{{ __('Alamat') }}</label>
                    <textarea name="alamat" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Emergency Call Name -->
                <div class="mb-4">
                    <label for="emergency_call_nama" class="block text-sm font-medium text-gray-700">{{ __('Emergency Call Name') }}</label>
                    <input type="text" name="emergency_call_nama" id="emergency_call_nama" value="{{ old('emergency_call_nama', $user->emergency_call_nama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('emergency_call_nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Emergency Call Number -->
                <div class="mb-4">
                    <label for="emergency_call_nomor" class="block text-sm font-medium text-gray-700">{{ __('Emergency Call Number') }}</label>
                    <input type="text" name="emergency_call_nomor" id="emergency_call_nomor" value="{{ old('emergency_call_nomor', $user->emergency_call_nomor) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('emergency_call_nomor')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Leave Quota -->
                <div class="mb-4">
                    <label for="jatah_cuti" class="block text-sm font-medium text-gray-700">{{ __('Leave Quota') }}</label>
                    <input type="number" name="jatah_cuti" id="jatah_cuti" value="{{ old('jatah_cuti', $user->jatah_cuti) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @error('jatah_cuti')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divisions -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">{{ __('Divisions') }}</label>
                    @foreach($divisions as $division)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="divisions[]" value="{{ $division->id }}" id="division_{{ $division->id }}" {{ in_array($division->id, old('divisions', $user->divisions->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label for="division_{{ $division->id }}" class="ml-2 text-sm text-gray-700">{{ $division->name }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- KTP Upload -->
                <div class="mb-4">
                    <label for="upload_ktp" class="block text-sm font-medium text-gray-700">{{ __('Upload KTP') }}</label>
                    <input type="file" name="upload_ktp" id="upload_ktp" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @if($user->upload_ktp)
                        <p class="text-gray-500 mt-1">Current File: <a href="{{ asset('storage/foto_ktp/' . basename($user->upload_ktp)) }}" class="text-blue-600 hover:text-blue-900" target="_blank">{{ basename($user->upload_ktp) }}</a></p>
                    @endif
                    @error('upload_ktp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">{{ __('Update User') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
