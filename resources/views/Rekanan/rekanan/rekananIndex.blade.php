@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <!-- Page Header -->
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl font-bold mb-2 md:mb-0">Halaman Data Rekanan</h1>
        <div class="flex-shrink-0">
            <a href="{{ route('rekanan.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Tambah Data Rekanan
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md" id="dataTable">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama PT</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NPWP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Usaha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti NPWP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Term Agreement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($rekanan as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->nama_pt }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->npwp }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->no_tlp }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->jenis_usaha }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->alamat }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($item->upload_npwp)
                                <a href="{{ asset('storage/' . $item->upload_npwp) }}" target="_blank" class="text-blue-500 hover:underline">Lihat Dokumen</a>
                            @else
                                Tidak ada dokumen
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">Net {{ $item->term_agrement }} Hari</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('rekanan.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('rekanan.delete', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for KTP Image -->
<div id="ktpModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg max-w-lg mx-auto">
            <h2 class="text-xl font-bold mb-4" id="ktpModalTitle">KTP</h2>
            <img id="ktpModalImage" src="" alt="KTP" class="max-w-full h-auto">
            <div class="text-right mt-4">
                <button onclick="closeKtpModal()" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showKtpModal(imageSrc, userName) {
        document.getElementById('ktpModalImage').src = imageSrc;
        document.getElementById('ktpModalTitle').textContent = 'KTP ' + userName;
        document.getElementById('ktpModal').classList.remove('hidden');
    }

    function closeKtpModal() {
        document.getElementById('ktpModal').classList.add('hidden');
    }
</script>
@endsection
