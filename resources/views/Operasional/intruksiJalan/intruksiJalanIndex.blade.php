@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl font-bold mb-2 md:mb-0">Daftar Instruksi Jalan</h1>
        <div class="flex-shrink-0">
            <a href="{{ route('intruksiJalan.viewCreate') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Tambah Data
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 relative" id="success-alert">
            {{ session('success') }}
            <button type="button" class="absolute top-0 right-0 p-2 text-white" onclick="document.getElementById('success-alert').remove();">
                &times;
            </button>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border-b">No Surat Jalan</th>
                    <th class="py-2 px-4 border-b">Order</th>
                    <th class="py-2 px-4 border-b">Driver</th>
                    <th class="py-2 px-4 border-b">Kenek</th>
                    <th class="py-2 px-4 border-b">No Pol</th>
                    <th class="py-2 px-4 border-b">Tanggal Jalan</th>
                    <th class="py-2 px-4 border-b">Estimasi Waktu</th>
                    <th class="py-2 px-4 border-b">Estimasi Jarak</th>
                    <th class="py-2 px-4 border-b">Dibuat Pada</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($intruksiJalans as $ij)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $ij->no_surat_jalan }}</td>
                        <td class="py-2 px-4 border-b">{{ $ij->order->no_order }}</td>
                        <td class="py-2 px-4 border-b">{{ $ij->driver->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $ij->kenek->name ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $ij->nopol }}</td>
                        <td class="py-2 px-4 border-b">{{ $ij->tanggal_jalan->format('Y-m-d')}}</td>
                        <td class="py-2 px-4 border-b">{{ $ij->estimasi_waktu_ke_tujuan }} Jam</td>
                        <td class="py-2 px-4 border-b">{{ $ij->estimasi_jarak }} KM</td>
                        <td class="py-2 px-4 border-b">{{ $ij->created_at->format('d-m-Y H:i:s') }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex items-center">
                                <a href="{{ route('instruksi_jalan.edit', $ij->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded mr-2">Edit</a>
                                @if(auth()->check() && (auth()->user()->role_id == 1 || auth()->user()->divisions->contains('name', 'operasional')))
                                    <form action="{{ route('intruksiJalan.delete', $ij->id) }}" method="POST" onsubmit="return confirm('{{ __('Apakah Anda yakin ingin menghapus instruksi jalan ini?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
