@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-semibold mb-8">Create Leave Request</h1>

    <form action="{{ route('pengajuan-izin-sakit.store') }}" method="POST" enctype="multipart/form-data" id="izinForm">
        @csrf

        <!-- Jenis Izin Field -->
        <div class="mb-4">
            <label for="jenis" class="block text-sm font-medium text-gray-700">Pilih Jenis Izin</label>
            <select name="jenis" id="jenis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('jenis') border-red-500 @enderror" required>
                <option value="" disabled selected>Pilih Jenis Izin</option>
                <option value="izin" {{ old('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
                <option value="sakit" {{ old('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
            </select>
            @error('jenis')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Container for Izin -->
        <div id="izinFormContainer" class="hidden">
            
            <!-- Tanggal Mulai Field -->
            <div class="mb-4">
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('tanggal_mulai') border-red-500 @enderror" value="{{ old('tanggal_mulai') }}" required>
                @error('tanggal_mulai')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Akhir Field -->
            <div class="mb-4">
                <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('tanggal_akhir') border-red-500 @enderror" value="{{ old('tanggal_akhir') }}" required>
                @error('tanggal_akhir')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alasan Field -->
            <div class="mb-4">
                <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan</label>
                <textarea id="alasan" name="alasan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('alasan') border-red-500 @enderror" required>{{ old('alasan') }}</textarea>
                @error('alasan')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jatah Cuti Field (Conditional) -->
            <div id="jatahCutiField" class="mb-4 hidden">
                <label for="jatah_cuti" class="block text-sm font-medium text-gray-700">Jatah Cuti Saat Ini: 
                    <span id="jatahCutiValue">{{ isset($user) ? $user->jatah_cuti : '-' }}</span>
                </label>
            </div>

            <!-- Bukti Dokumen Field (Conditional) -->
            <div id="buktiDokumenField" class="mb-4 hidden">
                <label for="bukti_dokumen" class="block text-sm font-medium text-gray-700">Bukti Dokumen (opsional)</label>
                <input type="file" id="bukti_dokumen" name="bukti_dokumen" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('bukti_dokumen') border-red-500 @enderror">
                @error('bukti_dokumen')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Ajukan Izin Sakit</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#jenis').change(function() {
            var jenis = $(this).val();
            if (!jenis) {
                $('#izinFormContainer').hide();
            } else {
                $('#izinFormContainer').show();
                if (jenis === 'izin') {
                    $('#jatahCutiField').show();
                    $('#buktiDokumenField').hide();
                } else if (jenis === 'sakit') {
                    $('#jatahCutiField').hide();
                    checkAndShowBuktiDokumen();
                }
            }
        });

        $('#tanggal_mulai, #tanggal_akhir').change(function() {
            checkAndShowBuktiDokumen();
        });

        function checkAndShowBuktiDokumen() {
            var jenis = $('#jenis').val();
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalAkhir = $('#tanggal_akhir').val();

            if (jenis === 'sakit') {
                var diffInMs = new Date(tanggalAkhir) - new Date(tanggalMulai);
                var diffInDays = diffInMs / (1000 * 60 * 60 * 24);

                if (diffInDays >= 3) {
                    $('#buktiDokumenField').show();
                } else {
                    $('#buktiDokumenField').hide();
                }
            }
        }

        // Trigger change event on jenis on page load
        $('#jenis').change();
    });
</script>
@endsection
