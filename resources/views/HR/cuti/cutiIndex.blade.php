@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Leave Request Management') }}</h1>

    <div class="flex justify-center">
        <div class="w-full lg:w-10/12">
            @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4 relative" id="success-alert">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 p-2 text-white" onclick="document.getElementById('success-alert').remove();">
                    &times;
                </button>
            </div>
        @endif
            <div class="bg-white shadow-md rounded mb-4">
                <div class="p-6">
                    <!-- Add Leave Request Button -->
                    <a href="/create-cuti" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        Ajukan Cuti
                    </a>

                    <!-- Current Leave Quota -->
                    <p class="block text-sm font-medium text-gray-700 mb-4">
                        Jatah Cuti Saat Ini:
                        <span id="jatahCutiValue">
                            {{ $tab == 'history' ? $remainingLeave : $user->jatah_cuti }}
                        </span>
                    </p>

                    <!-- Tab Navigation -->
                    <ul class="flex border-b mb-4">
                        <li class="mr-1">
                            <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 {{ $tab == 'pending' ? 'border-l border-t border-r rounded-t bg-white' : '' }}"
                               href="{{ route('pengajuan.cuti.index', ['tab' => 'pending']) }}">
                               Pending
                            </a>
                        </li>
                        <li class="mr-1">
                            <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 {{ $tab == 'history' ? 'border-l border-t border-r rounded-t bg-white' : '' }}"
                               href="{{ route('pengajuan.cuti.index', ['tab' => 'history']) }}">
                               History
                            </a>
                        </li>
                    </ul>

                    <!-- Leave Requests Table -->
                    <div class="overflow-x-auto">
                        @if($tab == 'pending' && $cutis->isEmpty())
                            <p class="text-center text-gray-600">Kamu belum mengajukan cuti atau semua pengajuan cuti telah diproses.</p>
                        @elseif($tab == 'history' && $cutis->isEmpty())
                            <p class="text-center text-gray-600">Tidak ada riwayat cuti.</p>
                        @else
                            <table class="min-w-full bg-white divide-y divide-gray-200">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">ID</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Karyawan</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Tanggal Mulai</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Tanggal Akhir</th>
                                        <th class="w-3/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Alasan</th>
                                        <th class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Status</th>
                                        <th class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Sisa Cuti</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Dibuat Pada</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Approved/Rejected By</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($cutis as $cuti)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $cuti->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $cuti->karyawan->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ is_string($cuti->tanggal_mulai) ? \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d-m-Y') : $cuti->tanggal_mulai->format('d-m-Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ is_string($cuti->tanggal_akhir) ? \Carbon\Carbon::parse($cuti->tanggal_akhir)->format('d-m-Y') : $cuti->tanggal_akhir->format('d-m-Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $cuti->alasan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($cuti->status == 'Pending')
                                                    <span class="bg-yellow-200 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Pending</span>
                                                @elseif($cuti->status == 'Diterima')
                                                    <span class="bg-green-200 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Approved</span>
                                                @elseif($cuti->status == 'Ditolak')
                                                    <span class="bg-red-200 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Rejected</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($tab == 'history')
                                                    {{ $cuti->status == 'Diterima' ? ($remainingLeave + 1) : '-' }}
                                                @else
                                                    {{ $cuti->karyawan->jatah_cuti }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ is_string($cuti->created_at) ? \Carbon\Carbon::parse($cuti->created_at)->format('d-m-Y H:i') : $cuti->created_at->format('d-m-Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $cuti->approved_by ? $cuti->approvedBy->name : '-' }}</td>
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
