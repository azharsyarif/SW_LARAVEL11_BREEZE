@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Approval Cuti & Izin Sakit') }}</h1>

    <div class="flex justify-center">
        <div class="w-full lg:w-10/12">
            <div class="bg-white shadow-md rounded mb-4">
                <div class="p-6">
                    <ul class="flex border-b mb-4">
                        <li class="mr-1">
                            <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 {{ $tab == 'pending' ? 'border-l border-t border-r rounded-t bg-white' : '' }}" href="{{ route('approval.index', ['tab' => 'pending']) }}">
                                Pending
                                @if($pendingCount > 0)
                                    <span class="bg-red-500 text-white text-xs font-semibold ml-2 px-2.5 py-0.5 rounded-full">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="mr-1">
                            <a class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 {{ $tab == 'history' ? 'border-l border-t border-r rounded-t bg-white' : '' }}" href="{{ route('approval.index', ['tab' => 'history']) }}">
                                History
                                @if($historyCount > 0)
                                    <span class="bg-gray-500 text-white text-xs font-semibold ml-2 px-2.5 py-0.5 rounded-full">{{ $historyCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                    <div class="overflow-x-auto">
                        @if($tab == 'pending' && $pengajuan->isEmpty())
                            <p class="text-center text-gray-600">Tidak ada cuti atau izin sakit yang pending.</p>
                        @else
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">ID</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Karyawan</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Jenis</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Tanggal Mulai</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Tanggal Akhir</th>
                                        <th class="w-3/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Alasan</th>
                                        <th class="w-1/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Status</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Dibuat Pada</th>
                                        <th class="w-2/12 px-6 py-3 text-left text-xs font-medium text-gray-200 uppercase tracking-wider">Approved/Rejected By</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($pengajuan as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->karyawan->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($item instanceof App\Models\PengajuanCuti)
                                                    Cuti
                                                @elseif($item instanceof App\Models\PengajuanIzinSakit)
                                                    Izin Sakit
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->tanggal_mulai }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->tanggal_akhir }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->alasan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($item->status == 'Pending')
                                                    <div class="flex flex-col md:flex-row">
                                                        @if($item instanceof App\Models\PengajuanCuti)
                                                            <form action="{{ route('cuti.approve', $item->id) }}" method="POST" class="inline-block mb-2 md:mb-0 md:mr-2">
                                                                @csrf
                                                                <button type="submit" class="px-4 py-2 bg-green-500 text-white text-xs font-semibold rounded-lg hover:bg-green-600">Approve</button>
                                                            </form>
                                                            <form action="{{ route('cuti.reject', $item->id) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                <button type="submit" class="px-4 py-2 bg-red-500 text-white text-xs font-semibold rounded-lg hover:bg-red-600">Reject</button>
                                                            </form>
                                                        @elseif($item instanceof App\Models\PengajuanIzinSakit)
                                                            <form action="{{ route('izin-sakit.approve', $item->id) }}" method="POST" class="inline-block mb-2 md:mb-0 md:mr-2">
                                                                @csrf
                                                                <button type="submit" class="px-4 py-2 bg-green-500 text-white text-xs font-semibold rounded-lg hover:bg-green-600">Approve</button>
                                                            </form>
                                                            <form action="{{ route('izin-sakit.reject', $item->id) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                <button type="submit" class="px-4 py-2 bg-red-500 text-white text-xs font-semibold rounded-lg hover:bg-red-600">Reject</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-600">{{ ucfirst($item->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($item->approved_by)
                                                    {{ $item->approved_by }}
                                                @else
                                                    N/A
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
