@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h4 class="text-xl font-bold text-gray-800 mb-4">Create Kendaraan</h4>
            <form action="{{ route('kendaraan.store') }}" method="POST">
                @csrf

                <!-- First row: Basic details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Column 1 -->
                    <div>
                        <label for="nopol" class="block text-sm font-medium text-gray-700">Nomor Polisi</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('nopol') border-red-500 @enderror" id="nopol" name="nopol" value="{{ old('nopol') }}" required>
                        @error('nopol')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jenis_kendaraan" class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('jenis_kendaraan') border-red-500 @enderror" id="jenis_kendaraan" name="jenis_kendaraan" value="{{ old('jenis_kendaraan') }}" required>
                        @error('jenis_kendaraan')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Second row: Vehicle Identification -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Column 1 -->
                    <div>
                        <label for="no_rangka" class="block text-sm font-medium text-gray-700">Nomor Rangka</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('no_rangka') border-red-500 @enderror" id="no_rangka" name="no_rangka" value="{{ old('no_rangka') }}" required>
                        @error('no_rangka')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="berat_maksimal" class="block text-sm font-medium text-gray-700">Berat Maksimal (kg)</label>
                        <input type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('berat_maksimal') border-red-500 @enderror" id="berat_maksimal" name="berat_maksimal" value="{{ old('berat_maksimal') }}" required>
                        @error('berat_maksimal')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Third row: Dimensions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <!-- Column 1 -->
                    <div>
                        <label for="panjang" class="block text-sm font-medium text-gray-700">Panjang (meter)</label>
                        <input type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('panjang') border-red-500 @enderror" id="panjang" name="panjang" value="{{ old('panjang') }}" required>
                        @error('panjang')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Column 2 -->
                    <div>
                        <label for="lebar" class="block text-sm font-medium text-gray-700">Lebar (meter)</label>
                        <input type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('lebar') border-red-500 @enderror" id="lebar" name="lebar" value="{{ old('lebar') }}" required>
                        @error('lebar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Column 3 -->
                    <div>
                        <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (meter)</label>
                        <input type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('tinggi') border-red-500 @enderror" id="tinggi" name="tinggi" value="{{ old('tinggi') }}" required>
                        @error('tinggi')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fourth row: Tax information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Column 1 -->
                    <div>
                        <label for="tanggal_pajak_plat" class="block text-sm font-medium text-gray-700">Tanggal Pajak Plat</label>
                        <input type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('tanggal_pajak_plat') border-red-500 @enderror" id="tanggal_pajak_plat" name="tanggal_pajak_plat" value="{{ old('tanggal_pajak_plat') }}" required>
                        @error('tanggal_pajak_plat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Column 2 -->
                    <div>
                        <label for="tanggal_pajak_stnk" class="block text-sm font-medium text-gray-700">Tanggal Pajak STNK</label>
                        <input type="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('tanggal_pajak_stnk') border-red-500 @enderror" id="tanggal_pajak_stnk" name="tanggal_pajak_stnk" value="{{ old('tanggal_pajak_stnk') }}" required>
                        @error('tanggal_pajak_stnk')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit button -->
                <div class="mt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
