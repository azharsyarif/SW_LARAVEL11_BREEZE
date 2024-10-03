@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-800">{{ __('Daftar Kendaraan') }}</h1>
        <a href="{{ route('kendaraan.viewCreate') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Tambah Data
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 relative" id="success-alert">
            {{ session('success') }}
            <button type="button" class="absolute top-0 right-0 p-2 text-white" onclick="document.getElementById('success-alert').remove();">
                &times;
            </button>
        </div>
    @endif
    <div class="flex flex-col justify-center">

        <!-- Table Kendaraan -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Polisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kendaraan</th>
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Panjang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lebar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tinggi</th> --}}
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat Maksimal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Rangka</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pajak Plat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pajak STNK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($kendaraans as $kendaraan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->nopol }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->jenis_kendaraan }}</td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->panjang }} Meter</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->lebar }} Meter</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->tinggi }} Meter</td> --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->berat_maksimal }} KG</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->no_rangka }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->tanggal_pajak_plat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kendaraan->tanggal_pajak_stnk }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('kendaraaan.edit', $kendaraan->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('kendaraan.delete', $kendaraan->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Table Kendaraan -->

        <!-- Form Tambah/Edit Kendaraan -->
        <div id="formTambahData" class="hidden bg-white shadow-lg rounded-lg p-6 mb-6">
            <h5 class="text-lg font-semibold mb-4">Form Tambah/Edit Kendaraan</h5>
            <!-- Add your form fields here -->
        </div>
        <!-- End Form Tambah/Edit Kendaraan -->

    </div>

@endsection
