@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">{{ __('Daftar Data PO Customer') }}</h1>

        <!-- Tabel PO Customer -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4 relative" id="success-alert">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 p-2 text-white" onclick="document.getElementById('success-alert').remove();">
                    &times;
                </button>
            </div>
        @endif
        <div class="bg-white shadow-md rounded-lg mb-6">
            <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                <!-- Tombol Tambah Data -->
                <a href="{{ route('marketing.po.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Tambah Data
                </a>
            </div>

            <!-- Tabel Responsive -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No PO</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama PT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PIC Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($poCustomers as $poCustomer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $poCustomer->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $poCustomer->no_po }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $poCustomer->rekanan->nama_pt }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $poCustomer->alamat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $poCustomer->picCustomer->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $poCustomer->created_at->format('d-m-Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $poCustomer->updated_at->format('d-m-Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('marketing.po.viewEdit', $poCustomer->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('marketing.po.destroy', $poCustomer->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include jQuery script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
