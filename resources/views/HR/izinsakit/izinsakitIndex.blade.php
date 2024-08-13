@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <h1 class="text-3xl font-semibold text-gray-800 mb-8">{{ __('Pengajuan Izin Sakit') }}</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-4xl">
            <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6">
                <a href="/create-izin-sakit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded mb-6 inline-block hover:bg-blue-700">
                    Ajukan Izin Sakit
                </a>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">ID</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Karyawan</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Tanggal Mulai</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Tanggal Akhir</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Alasan</th>
                                <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Jenis</th> <!-- New column for Jenis (Type) -->
                                <th class="px-4 py-2 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($izinSakits as $izinsakit)
                                <tr>
                                    <td class="px-4 py-2 border-b border-gray-200 text-sm text-gray-700">{{ $izinsakit->id }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-sm text-gray-700">{{ $izinsakit->karyawan->name }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-sm text-gray-700">{{ $izinsakit->tanggal_mulai }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-sm text-gray-700">{{ $izinsakit->tanggal_akhir }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-sm text-gray-700">{{ $izinsakit->alasan }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-sm text-gray-700">{{ $izinsakit->jenis }}</td>
                                    <td class="px-4 py-2 border-b border-gray-200 text-sm text-gray-700">{{ $izinsakit->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
