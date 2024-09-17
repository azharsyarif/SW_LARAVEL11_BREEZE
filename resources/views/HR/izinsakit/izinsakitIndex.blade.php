@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Pengajuan Izin Sakit') }}</h1>

    <div class="flex justify-center">
        <div class="w-full lg:w-10/12">
            <div class="bg-white shadow-md rounded mb-4">
                <div class="p-6">
                    <!-- Add Leave Request Button -->
                    <a href="/create-izin-sakit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        Ajukan Izin Sakit
                    </a>
                    
                    <!-- Leave Requests Table -->
                    <div class="overflow-x-auto">
                        @if($izinSakits->isEmpty())
                            <p class="text-center text-gray-600">Kamu Belum Mengajukan Izin Sakit.</p>
                        @else
                            <table class="min-w-full bg-white divide-y divide-gray-200">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">ID</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Karyawan</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Tanggal Mulai</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Tanggal Akhir</th>
                                        <th class="w-3/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Alasan</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Jenis</th> <!-- New column for Jenis (Type) -->
                                        <th class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($izinSakits as $izinsakit)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $izinsakit->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $izinsakit->karyawan->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($izinsakit->tanggal_mulai)->format('d-m-Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($izinsakit->tanggal_akhir)->format('d-m-Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $izinsakit->alasan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $izinsakit->jenis }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($izinsakit->status == 'Pending')
                                                    <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Pending</span>
                                                @elseif($izinsakit->status == 'Diterima')
                                                    <span class="bg-green-200 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Approved</span>
                                                @elseif($izinsakit->status == 'Ditolak')
                                                    <span class="bg-red-200 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
