@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-xl font-bold text-gray-800 mb-6">{{ __('Daftar Service Kendaraan') }}</h1>

        <div class="flex justify-end mb-4">
            <a href="/op-service-kendaraan/create" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Tambah Data</a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4 relative" id="success-alert">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 p-2 text-white" onclick="document.getElementById('success-alert').remove();">
                    &times;
                </button>
            </div>
        @endif


        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="table-responsive">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Polisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat Pada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diupdate Pada</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($services as $service)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->no_service }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->kendaraan->nopol }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->driver->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->total_service }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($service->upload_dokumen)
                                        <a href="{{ asset('storage/' . $service->upload_dokumen) }}" class="text-blue-500 hover:underline" target="_blank">Lihat Dokumen</a>
                                    @else
                                        <span class="text-gray-500">Tidak ada dokumen</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->created_at->format('d-m-Y H:i:s')}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $service->updated_at->format('d-m-Y H:i:s')}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('service.viewEdit', $service->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('service.delete', $service->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Tambah/Edit Service Kendaraan -->
        <div class="bg-white shadow-md rounded-lg mt-6 p-6 hidden" id="formTambahData">
            <h5 class="text-lg font-semibold mb-4">Form Tambah/Edit Service Kendaraan</h5>
            <div id="item_conditions">
                <!-- Dynamic items will be inserted here -->
            </div>
            <button type="button" id="btnTambahItem" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Tambah Item</button>
        </div>
        <!-- End Form Tambah/Edit Service Kendaraan -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btnTambahData').click(function() {
                $('#formTambahData').toggle('medium');
                $(this).text($(this).text() === 'Tambah Data' ? 'Tutup Form' : 'Tambah Data');
            });

            var nextItemNumber = 1;
            $('#btnTambahItem').click(function() {
                var newItem = `
                <div class="flex items-center mb-2" id="item_${nextItemNumber}">
                    <div class="w-1/3">
                        <input type="text" class="form-input mt-1 block w-full border-gray-300 rounded-md" name="item_name[]" placeholder="Nama Komponen" required>
                    </div>
                    <div class="w-1/3 mx-2">
                        <select class="form-select mt-1 block w-full border-gray-300 rounded-md" name="item_value[]" required onchange="showDescription(this)">
                            <option value="">Pilih Kondisi</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                    <div class="w-1/4">
                        <input type="text" class="form-input mt-1 block w-full border-gray-300 rounded-md" name="desc[]" placeholder="Deskripsi" style="display:none;">
                    </div>
                    <div class="ml-2">
                        <button type="button" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600" onclick="hapusItem(${nextItemNumber})">X</button>
                    </div>
                </div>
            `;
                $('#item_conditions').append(newItem);
                nextItemNumber++;
            });

            window.hapusItem = function(id) {
                $('#item_' + id).remove();
            };

            window.showDescription = function(select) {
                var descInput = $(select).closest('.flex').find('input[name="desc[]"]');
                if (select.value === 'Rusak') {
                    descInput.show();
                } else {
                    descInput.hide();
                }
            };
        });
    </script>
@endsection
