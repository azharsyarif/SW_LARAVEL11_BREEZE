@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-gray-800 text-white px-6 py-4 rounded-t-lg">
                <h2 class="text-lg font-semibold">Create Order</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('marketing.order.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-gray-100 p-4 rounded-lg mb-6">
                        <h3 class="text-gray-700 text-lg font-semibold mb-4">Form Data Order</h3>

                        <!-- No PO Customer -->
                        <div class="mb-4">
                            <label for="no_po" class="block text-gray-700 font-medium">No PO Customer</label>
                            <select class="block w-full mt-1 rounded-md border-gray-300 @error('no_po') border-red-500 @enderror" id="no_po" name="no_po" required>
                                <option value="">Pilih No PO Customer</option>
                                @foreach ($pOCustomers as $poCustomer)
                                    <option value="{{ $poCustomer->id }}" data-rekanan-id="{{ $poCustomer->rekanan_id }}" {{ old('no_po') == $poCustomer->id ? 'selected' : '' }}>{{ $poCustomer->no_po }}</option>
                                @endforeach
                            </select>
                            @error('no_po')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Asal -->
                        <div class="mb-4">
                            <label for="asal" class="block text-gray-700 font-medium">Asal</label>
                            <select class="block w-full mt-1 rounded-md border-gray-300 select2 @error('asal') border-red-500 @enderror" id="asal" name="asal" required>
                                <option value="">Pilih Kota Asal</option>
                            </select>
                            @error('asal')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tujuan -->
                        <div class="mb-4">
                            <label for="tujuan" class="block text-gray-700 font-medium">Tujuan</label>
                            <select class="block w-full mt-1 rounded-md border-gray-300 select2 @error('tujuan') border-red @enderror" id="tujuan" name="tujuan" required>
                                <option value="">Pilih Kota Tujuan</option>
                            </select>
                            @error('tujuan')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total KM -->
                        <div class="mb-4">
                            <label for="total_km" class="block text-gray-700 font-medium">Total KM</label>
                            <input type="text" class="block w-full mt-1 rounded-md border-gray-300 @error('total_km') border-red-500 @enderror" id="total_km" name="total_km" value="{{ old('total_km') }}" required>
                            @error('total_km')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Koli -->
                        <div class="mb-4">
                            <label for="total_koli" class="block text-gray-700 font-medium">Total Koli</label>
                            <input type="text" class="block w-full mt-1 rounded-md border-gray-300 @error('total_koli') border-red-500 @enderror" id="total_koli" name="total_koli" value="{{ old('total_koli') }}" required>
                            @error('total_koli')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Berat -->
                        <div class="mb-4">
                            <label for="total_berat" class="block text-gray-700 font-medium">Total Berat</label>
                            <input type="text" class="block w-full mt-1 rounded-md border-gray-300 @error('total_berat') border-red-500 @enderror" id="total_berat" name="total_berat" value="{{ old('total_berat') }}">
                            @error('total_berat')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi Barang -->
                        <div class="mb-4">
                            <label for="deskripsi_barang" class="block text-gray-700 font-medium">Deskripsi Barang</label>
                            <textarea class="block w-full mt-1 rounded-md border-gray-300 @error('deskripsi_barang') border-red-500 @enderror" id="deskripsi_barang" name="deskripsi_barang" rows="3" required>{{ old('deskripsi_barang') }}</textarea>
                            @error('deskripsi_barang')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Term Agreement -->
                        <div class="mb-4">
                            <label for="term_agrement" class="block text-gray-700 font-medium">Term Agreement</label>
                            <input type="text" class="block w-full mt-1 rounded-md border-gray-300 @error('term_agrement') border-red-500 @enderror" id="term_agrement" name="term_agrement" value="{{ old('term_agrement', $term_agreement) }}" readonly>
                            @error('term_agrement')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Layanan -->
                        <div class="mb-4">
                            <label for="layanan" class="block text-gray-700 font-medium">Layanan</label>
                            <select class="block w-full mt-1 rounded-md border-gray-300 @error('layanan') border-red-500 @enderror" id="layanan" name="layanan" required>
                                <option value="">Pilih Layanan</option>
                                <option value="darat">Darat</option>
                                <option value="laut">Laut</option>
                                <option value="udara">Udara</option>
                                <option value="mobil">Mobil</option>
                            </select>
                            @error('layanan')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kendaraan -->
                        <div class="mb-4" id="kendaraan-container" style="display: none;">
                            <label for="kendaraan_id" class="block text-gray-700 font-medium">Kendaraan</label>
                            <select class="block w-full mt-1 rounded-md border-gray-300 @error('kendaraan_id') border-red-500 @enderror" id="kendaraan_id" name="kendaraan_id">
                                <option value="">Pilih Kendaraan</option>
                                @foreach ($kendaraans as $kendaraan)
                                    <option value="{{ $kendaraan->id }}">{{ $kendaraan->nopol }}</option>
                                @endforeach
                            </select>
                            @error('kendaraan_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Deal -->
                        <div class="mb-4">
                            <label for="harga_deal" class="block text-gray-700 font-medium">Harga Deal</label>
                            <input type="text" class="block w-full mt-1 rounded-md border-gray-300 @error('harga_deal') border-red-500 @enderror" id="harga_deal" name="harga_deal" value="{{ old('harga_deal') }}">
                            @error('harga_deal')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Harga Deal -->
                        <div class="mb-4">
                            <label for="total_harga_deal" class="block text-gray-700 font-medium">Total Harga Deal</label>
                            <input type="text" class="block w-full mt-1 rounded-md border-gray-300 @error('total_harga_deal') border-red-500 @enderror" id="total_harga_deal" name="total_harga_deal" value="@currency(old('total_harga_deal'))" readonly>
                            @error('total_harga_deal')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Harga Deal -->
                        <div class="mb-4">
                            <label for="upload_harga_deal" class="block text-gray-700 font-medium">Upload Harga Deal</label>
                            <input type="file" class="block w-full mt-1 rounded-md border-gray-300 @error('upload_harga_deal') border-red-500 @enderror" id="upload_harga_deal" name="upload_harga_deal">
                            @error('upload_harga_deal')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Create Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch cities and populate select options
        function fetchCities() {
        $.ajax({
            url: '/cities',
            type: 'GET',
            success: function(response) {
                var asalSelect = $('#asal');
                var tujuanSelect = $('#tujuan');
                asalSelect.empty();
                tujuanSelect.empty();
                asalSelect.append('<option value="">Pilih Kota Asal</option>');
                tujuanSelect.append('<option value="">Pilih Kota Tujuan</option>');
                $.each(response, function(index, city) {
                    asalSelect.append('<option value="' + city.city_id + '">' + city.city_name + '</option>');
                    tujuanSelect.append('<option value="' + city.city_id + '">' + city.city_name + '</option>');
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    fetchCities();

            $('#no_po').change(function() {
            var selectedOption = $(this).find('option:selected');
            var rekananId = selectedOption.data('rekanan-id');

            // Fetch the term agreement based on the rekananId
            var termAgreement = '';
            @foreach($rekanans as $rekanan)
                if (rekananId == {{ $rekanan->id }}) {
                    termAgreement = "{{ $rekanan->term_agrement }}";
                }
            @endforeach

            $('#term_agrement').val(termAgreement);
        });

    });
</script>
<script>
    $(document).ready(function() {
        $('#layanan').change(function() {
            var selectedLayanan = $(this).val();
            if (selectedLayanan == 'mobil') {
                $('#kendaraan-container').show();
            } else {
                $('#kendaraan-container').hide();
                $('#kendaraan_id').val(''); // Clear the selected value if not 'mobil'
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function calculateTotalHargaDeal() {
            var hargaDeal = parseFloat($('#harga_deal').val().replace(/,/g, '')) || 0;
            var totalBerat = parseFloat($('#total_berat').val().replace(/,/g, '')) || 0;
            var totalHargaDeal = hargaDeal * totalBerat;
            $('#total_harga_deal').val(totalHargaDeal.toFixed(2));
        }

        // Event listeners for changes in harga_deal and total_berat
        $('#harga_deal, #total_berat').on('input', function() {
            calculateTotalHargaDeal();
        });

        // Initial calculation on page load
        calculateTotalHargaDeal();
    });
</script>

@endsection
