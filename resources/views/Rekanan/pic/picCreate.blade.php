@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Form Data PIC Customer</h1>

    <form action="{{ route('pic.customer.store') }}" method="POST">
        @csrf

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="text-lg font-semibold mb-6">Form Data PIC Customer</div>
            
            <!-- Nama PT -->
            <div class="mb-4">
                <label for="nama_pt" class="block text-sm font-medium text-gray-700">Nama PT</label>
                <select class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 @error('nama_pt') border-red-500 @enderror" id="nama_pt" name="nama_pt" required>
                    <option value="">Pilih Nama PT</option>
                    @foreach($rekanans as $rekanan)
                        <option value="{{ $rekanan->id }}" {{ old('nama_pt') == $rekanan->id ? 'selected' : '' }}>{{ $rekanan->nama_pt }}</option>
                    @endforeach
                </select>
                @error('nama_pt')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 @error('nama') border-red-500 @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- No Tlp -->
            <div class="mb-4">
                <label for="no_tlp" class="block text-sm font-medium text-gray-700">No Tlp</label>
                <input type="text" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 @error('no_tlp') border-red-500 @enderror" id="no_tlp" name="no_tlp" value="{{ old('no_tlp') }}" required>
                @error('no_tlp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Posisi -->
            <div class="mb-4">
                <label for="posisi" class="block text-sm font-medium text-gray-700">Posisi</label>
                <input type="text" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 @error('posisi') border-red-500 @enderror" id="posisi" name="posisi" value="{{ old('posisi') }}" required>
                @error('posisi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cabang -->
            <div class="mb-4">
                <label for="cabang" class="block text-sm font-medium text-gray-700">Cabang</label>
                <input type="text" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50 @error('cabang') border-red-500 @enderror" id="cabang" name="cabang" value="{{ old('cabang') }}" required>
                @error('cabang')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-right mt-6">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
