@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="bg-gray-100 shadow rounded-lg p-4 mb-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Service Kendaraan Info</h3>
            <p class="text-sm text-gray-600">
                <strong>Dibuat:</strong> {{ $serviceKendaraan->created_at->format('d M Y, H:i') }}
            </p>
            <p class="text-sm text-gray-600">
                <strong>Terakhir di Edit:</strong> {{ $serviceKendaraan->updated_at->format('d M Y, H:i') }}
            </p>
        </div>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Edit Service Kendaraan</h2>
                <p class="text-sm text-gray-500">(Jika di halaman edit ada data yang hilang, mohon diisi ulang kembali)</p>
            </div>
            <div class="p-6">
                <form action="{{ route('service.update', $serviceKendaraan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nopol" class="block text-gray-700 font-medium">Nomor Polisi Kendaraan</label>
                        <select class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('nopol') border-red-500 @enderror" id="nopol" name="nopol" required>
                            <option value="">Pilih Nomor Polisi</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" {{ $serviceKendaraan->nopol == $kendaraan->id ? 'selected' : '' }}>{{ $kendaraan->nopol }}</option>
                            @endforeach
                        </select>
                        @error('nopol')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="driver_id" class="block text-gray-700 font-medium">Driver</label>
                        <select class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('driver_id') border-red-500 @enderror" id="driver_id" name="driver_id" required>
                            <option value="">Pilih Driver</option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ $serviceKendaraan->driver_id == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                            @endforeach
                        </select>
                        @error('driver_id')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="total_service" class="block text-gray-700 font-medium">Total Service</label>
                        <input type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('total_service') border-red-500 @enderror" id="total_service" name="total_service" value="{{ $serviceKendaraan->total_service }}" required>
                        @error('total_service')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="upload_dokumen" class="block text-gray-700 font-medium">Upload Dokumen</label>
                        <input type="file" class="mt-1 block w-full text-gray-700 border-gray-300 rounded-md shadow-sm @error('upload_dokumen') border-red-500 @enderror" id="upload_dokumen" name="upload_dokumen">
                        @error('upload_dokumen')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                        @if ($serviceKendaraan->upload_dokumen)
                            <a href="{{ asset('uploads/' . $serviceKendaraan->upload_dokumen) }}" target="_blank" class="text-blue-600 hover:underline mt-2 block">Lihat Dokumen</a>
                        @endif
                    </div>

                    <hr class="my-6">
                    <h5 class="text-lg font-medium">Kondisi Item</h5>
                    <p class="text-sm text-gray-600 mb-4">Isi dengan kondisi-kondisi barang kendaraan yang terkait dengan service ini.</p>

                    <div id="item_conditions" class="space-y-4">
                        @foreach($serviceKendaraan->kendaraanItemConditions as $condition)
                            <div class="grid grid-cols-12 gap-4" id="item_{{ $loop->index }}">
                                <div class="col-span-4">
                                    <input type="text" class="form-input w-full border-gray-300 rounded-md shadow-sm" name="item_name[]" value="{{ $condition->item_name }}" placeholder="Nama Komponen" required>
                                </div>
                                <div class="col-span-4">
                                    <select class="form-select w-full border-gray-300 rounded-md shadow-sm" name="item_value[]" required onchange="showDescription(this)">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Baik" {{ $condition->item_value == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak" {{ $condition->item_value == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                    </select>
                                </div>
                                <div class="col-span-3">
                                    <input type="text" class="form-input w-full border-gray-300 rounded-md shadow-sm" name="desc[]" value="{{ $condition->desc }}" placeholder="Deskripsi" {{ $condition->item_value == 'Rusak' ? '' : 'style=display:none;' }}>
                                </div>
                                <div class="col-span-1 flex items-center">
                                    <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md shadow-sm" onclick="hapusItem({{ $loop->index }})">X</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="btnTambahItem" class="bg-green-500 text-white px-4 py-2 mt-4 rounded-md shadow-sm">Tambah Kondisi Item</button>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            var nextItemNumber = {{ $serviceKendaraan->kendaraanItemConditions->count() }};

            $('#btnTambahItem').click(function() {
                var newItem = `
                <div class="grid grid-cols-12 gap-4 mb-4" id="item_${nextItemNumber}">
                    <div class="col-span-4">
                        <input type="text" class="form-input w-full border-gray-300 rounded-md shadow-sm" name="item_name[]" placeholder="Nama Komponen" required>
                    </div>
                    <div class="col-span-4">
                        <select class="form-select w-full border-gray-300 rounded-md shadow-sm" name="item_value[]" required onchange="showDescription(this)">
                            <option value="">Pilih Kondisi</option>
                            <option value="Baik">Baik</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input type="text" class="form-input w-full border-gray-300 rounded-md shadow-sm" name="desc[]" placeholder="Deskripsi" style="display:none;">
                    </div>
                    <div class="col-span-1 flex items-center">
                        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md shadow-sm" onclick="hapusItem(${nextItemNumber})">X</button>
                    </div>
                </div>
                `;
                $('#item_conditions').append(newItem);
                nextItemNumber++;
            });

            window.hapusItem = function(index) {
                $('#item_' + index).remove();
            };

            window.showDescription = function(selectElement) {
                var descField = $(selectElement).closest('.grid').find('input[name="desc[]"]');
                if (selectElement.value === 'Rusak') {
                    descField.show();
                } else {
                    descField.hide();
                }
            };
        });
    </script>
@endsection
