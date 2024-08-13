@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Create New User</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" id="name" name="name" class="w-full mt-1 p-2 border rounded" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full mt-1 p-2 border rounded" value="{{ old('email') }}" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="role_id">Role <small>(Menentukan hak akses karyawan)</small></label>
            <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="position_id" class="block text-gray-700">Position</label>
            <select id="position_id" name="position_id" class="w-full mt-1 p-2 border rounded" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700">Status</label>
            <select id="status" name="status" class="w-full mt-1 p-2 border rounded" required>
                <option value="tetap" {{ old('status') == 'tetap' ? 'selected' : '' }}>Karyawan Tetap</option>
                <option value="kontrak" {{ old('status') == 'kontrak' ? 'selected' : '' }}>Karyawan Kontrak</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal_join" class="block text-gray-700">Tanggal Join</label>
            <input type="date" id="tanggal_join" name="tanggal_join" class="w-full mt-1 p-2 border rounded" value="{{ old('tanggal_join') }}" required>
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-gray-700">Alamat</label>
            <textarea id="alamat" name="alamat" class="w-full mt-1 p-2 border rounded">{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="upload_ktp" class="block text-gray-700">Upload KTP</label>
            <input type="file" id="upload_ktp" name="upload_ktp" class="w-full mt-1 p-2 border rounded">
        </div>

        <div class="mb-4">
            <label for="emergency_call_nama" class="block text-gray-700">Emergency Call Name</label>
            <input type="text" id="emergency_call_nama" name="emergency_call_nama" class="w-full mt-1 p-2 border rounded" value="{{ old('emergency_call_nama') }}">
        </div>

        <div class="mb-4">
            <label for="emergency_call_nomor" class="block text-gray-700">Emergency Call Number</label>
            <input type="text" id="emergency_call_nomor" name="emergency_call_nomor" class="w-full mt-1 p-2 border rounded" value="{{ old('emergency_call_nomor') }}">
        </div>

        <div class="mb-4">
            <label for="jatah_cuti" class="block text-gray-700">Jatah Cuti</label>
            <input type="number" id="jatah_cuti" name="jatah_cuti" class="w-full mt-1 p-2 border rounded" value="{{ old('jatah_cuti', 12) }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Divisions</label>
            @foreach($divisions as $division)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="divisions[]" value="{{ $division->id }}" {{ in_array($division->id, old('divisions', [])) ? 'checked' : '' }}>
                    <span class="ml-2">{{ $division->name }}</span>
                </label>
            @endforeach
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create User</button>
        </div>
    </form>
</div>
@endsection
