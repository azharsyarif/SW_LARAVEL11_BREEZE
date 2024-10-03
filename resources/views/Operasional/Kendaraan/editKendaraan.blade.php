@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="bg-gray-100 shadow rounded-lg p-4 mb-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Kendaraan Info</h3>
            <p class="text-sm text-gray-600">
                <strong>Dibuat:</strong> {{ $kendaraan->created_at->format('d M Y, H:i') }}
            </p>
            <p class="text-sm text-gray-600">
                <strong>Terakhir di Edit:</strong> {{ $kendaraan->updated_at->format('d M Y, H:i') }}
            </p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold">Edit Kendaraan</h2>
            </div>

            <!-- Card for Created At and Last Modified -->
            <div class="bg-gray-100 shadow rounded-lg p-4 mb-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Kendaraan Info</h3>
                <p class="text-sm text-gray-600">
                    <strong>Created At:</strong> {{ $kendaraan->created_at->format('d M Y, H:i') }}
                </p>
                <p class="text-sm text-gray-600">
                    <strong>Last Modified:</strong> {{ $kendaraan->updated_at->format('d M Y, H:i') }}
                </p>
            </div>

            <form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <!-- Nomor Polisi -->
                        <div class="mb-4">
                            <label for="nopol" class="block text-sm font-medium text-gray-700">Nomor Polisi</label>
                            <input type="text" id="nopol" name="nopol"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('nopol') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('nopol', $kendaraan->nopol) }}" required>
                            @error('nopol')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kendaraan -->
                        <div class="mb-4">
                            <label for="jenis_kendaraan" class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
                            <input type="text" id="jenis_kendaraan" name="jenis_kendaraan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('jenis_kendaraan') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) }}" required>
                            @error('jenis_kendaraan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Panjang -->
                        <div class="mb-4">
                            <label for="panjang" class="block text-sm font-medium text-gray-700">Panjang (meter)</label>
                            <input type="number" step="0.01" id="panjang" name="panjang"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('panjang') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('panjang', $kendaraan->panjang) }}" required>
                            @error('panjang')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lebar -->
                        <div class="mb-4">
                            <label for="lebar" class="block text-sm font-medium text-gray-700">Lebar (meter)</label>
                            <input type="number" step="0.01" id="lebar" name="lebar"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('lebar') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('lebar', $kendaraan->lebar) }}" required>
                            @error('lebar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <!-- Tinggi -->
                        <div class="mb-4">
                            <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (meter)</label>
                            <input type="number" step="0.01" id="tinggi" name="tinggi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('tinggi') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('tinggi', $kendaraan->tinggi) }}" required>
                            @error('tinggi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Berat Maksimal -->
                        <div class="mb-4">
                            <label for="berat_maksimal" class="block text-sm font-medium text-gray-700">Berat Maksimal (kg)</label>
                            <input type="number" step="0.01" id="berat_maksimal" name="berat_maksimal"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('berat_maksimal') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('berat_maksimal', $kendaraan->berat_maksimal) }}" required>
                            @error('berat_maksimal')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Rangka -->
                        <div class="mb-4">
                            <label for="no_rangka" class="block text-sm font-medium text-gray-700">Nomor Rangka</label>
                            <input type="text" id="no_rangka" name="no_rangka"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('no_rangka') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('no_rangka', $kendaraan->no_rangka) }}" required>
                            @error('no_rangka')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Pajak Plat -->
                        <div class="mb-4">
                            <label for="tanggal_pajak_plat" class="block text-sm font-medium text-gray-700">Tanggal Pajak Plat</label>
                            <input type="date" id="tanggal_pajak_plat" name="tanggal_pajak_plat"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('tanggal_pajak_plat') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('tanggal_pajak_plat', $kendaraan->tanggal_pajak_plat) }}" required>
                            @error('tanggal_pajak_plat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Pajak STNK -->
                        <div class="mb-4">
                            <label for="tanggal_pajak_stnk" class="block text-sm font-medium text-gray-700">Tanggal Pajak STNK</label>
                            <input type="date" id="tanggal_pajak_stnk" name="tanggal_pajak_stnk"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('tanggal_pajak_stnk') border-red-500 @enderror focus:ring-indigo-500 focus:border-indigo-500"
                                value="{{ old('tanggal_pajak_stnk', $kendaraan->tanggal_pajak_stnk) }}" required>
                            @error('tanggal_pajak_stnk')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
