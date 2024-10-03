@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-800 text-white p-4">
                <h2 class="text-xl font-bold">Create Order</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="kendaraan_id" class="block text-sm font-medium text-gray-700">Nomor Polisi Kendaraan</label>
                        <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('kendaraan_id') border-red-500 @enderror" id="kendaraan_id" name="kendaraan_id" required>
                            <option value="">Pilih Nomor Polisi</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>{{ $kendaraan->nopol }}</option>
                            @endforeach
                        </select>
                        @error('kendaraan_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="driver_id" class="block text-sm font-medium text-gray-700">Driver</label>
                        <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('driver_id') border-red-500 @enderror" id="driver_id" name="driver_id" required>
                            <option value="">Pilih Driver</option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                            @endforeach
                        </select>
                        @error('driver_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="total_service" class="block text-sm font-medium text-gray-700">Total Service</label>
                        <input type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('total_service') border-red-500 @enderror" id="total_service" name="total_service" value="{{ old('total_service') }}" required>
                        @error('total_service')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="upload_dokumen" class="block text-sm font-medium text-gray-700">Upload Dokumen</label>
                        <input type="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('upload_dokumen') border-red-500 @enderror" id="upload_dokumen" name="upload_dokumen">
                        @error('upload_dokumen')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <h5 class="text-lg font-medium text-gray-700">Kondisi Item</h5>
                    <p class="text-sm text-gray-500 mb-4">Isi dengan kondisi-kondisi barang kendaraan yang terkait dengan service ini.</p>

                    <div id="item_conditions">
                        <!-- Dynamic item conditions fields will be appended here -->
                    </div>

                    <button type="button" id="btnTambahItem" class="bg-green-500 text-white px-3 py-2 rounded-md text-sm">Tambah Kondisi Item</button>

                    <div class="mt-6">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // Add dynamic item condition fields
            var nextItemNumber = 1;
            $('#btnTambahItem').click(function() {
                var newItem = `
                <div class="grid grid-cols-12 gap-4 mb-2" id="item_${nextItemNumber}">
                    <div class="col-span-4">
                        <input type="text" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full" name="item_name[]" placeholder="Nama Komponen" required>
                    </div>
                    <div class="col-span-4">
                        <select class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full" name="item_value[]" required onchange="showDescription(this)">
                            <option value="">Pilih Kondisi</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input type="text" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 w-full" name="desc[]" placeholder="Deskripsi" style="display:none;">
                    </div>
                    <div class="col-span-1">
                        <button type="button" class="bg-red-500 text-white px-3 py-1 rounded-md" onclick="hapusItem(${nextItemNumber})">X</button>
                    </div>
                </div>
            `;
                $('#item_conditions').append(newItem);
                nextItemNumber++;
            });

            // Function to remove item condition field
            window.hapusItem = function(id) {
                $('#item_' + id).remove();
            };

            // Function to show/hide description based on item condition
            window.showDescription = function(select) {
                var descInput = $(select).closest('.grid').find('input[name="desc[]"]');
                if (select.value === 'Rusak') {
                    descInput.show();
                } else {
                    descInput.hide();
                }
            };
        });
    </script>
@endsection
