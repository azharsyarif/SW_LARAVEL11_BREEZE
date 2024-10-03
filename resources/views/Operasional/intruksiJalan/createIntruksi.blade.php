@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Create Instruksi Jalan</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 mb-6 rounded-lg border border-red-200">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('instruksi_jalan.store') }}" method="POST">
        @csrf

        <!-- Order ID (simple select) -->
        <div class="mb-4">
            <label for="order_id" class="block text-sm font-medium text-gray-700">Order</label>
            <select name="order_id" id="order_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select Order</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}">{{ $order->no_order }}</option>
                @endforeach
            </select>
        </div>

            <!-- Driver Field -->
    <div class="mb-4">
        <label for="driver_id" class="block text-gray-700 font-medium">Driver</label>
        <select id="driver_id" name="driver_id" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <option value="">Select Driver</option>
            @foreach ($users as $user)
                @foreach ($user->divisions as $division)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $division->name }})</option>
                @endforeach
            @endforeach
        </select>
        @error('driver_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Kenek Field -->
    <div class="mb-4">
        <label for="kenek_id" class="block text-gray-700 font-medium">Kenek</label>
        <select id="kenek_id" name="kenek_id" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select Kenek</option>
            @foreach ($users as $user)
                @foreach ($user->divisions as $division)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $division->name }})</option>
                @endforeach
            @endforeach
        </select>
        @error('kenek_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
</div>


        <!-- Nopol (from kendaraan table) -->
        <div class="mb-4">
            <label for="nopol" class="block text-sm font-medium text-gray-700">Nopol (Kendaraan)</label>
            <select name="nopol" id="nopol" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="">Select Nopol</option>
                @foreach($kendaraans as $kendaraan)
                    <option value="{{ $kendaraan->nopol }}">{{ $kendaraan->nopol }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal Jalan -->
        <div class="mb-4">
            <label for="tanggal_jalan" class="block text-sm font-medium text-gray-700">Tanggal Jalan</label>
            <input type="date" name="tanggal_jalan" id="tanggal_jalan" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('tanggal_jalan') }}" required>
        </div>

        <!-- Tanggal Stuffing -->
        <div class="mb-4">
            <label for="tanggal_stuffing" class="block text-sm font-medium text-gray-700">Tanggal Stuffing (Optional)</label>
            <input type="date" name="tanggal_stuffing" id="tanggal_stuffing" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('tanggal_stuffing') }}">
        </div>

        <!-- Tanggal Stripping -->
        <div class="mb-4">
            <label for="tanggal_stripping" class="block text-sm font-medium text-gray-700">Tanggal Stripping (Optional)</label>
            <input type="date" name="tanggal_stripping" id="tanggal_stripping" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('tanggal_stripping') }}">
        </div>

        <!-- Estimasi Waktu ke Tujuan -->
        <div class="mb-4">
            <label for="estimasi_waktu_ke_tujuan" class="block text-sm font-medium text-gray-700">Estimasi Waktu ke Tujuan</label>
            <input type="text" name="estimasi_waktu_ke_tujuan" id="estimasi_waktu_ke_tujuan" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('estimasi_waktu_ke_tujuan') }}" required>
        </div>

        <!-- Estimasi Jarak -->
        <div class="mb-4">
            <label for="estimasi_jarak" class="block text-sm font-medium text-gray-700">Estimasi Jarak</label>
            <input type="text" name="estimasi_jarak" id="estimasi_jarak" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('estimasi_jarak') }}" required>
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="w-full px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Submit</button>
        </div>
    </form>
</div>

<!-- jQuery and Select2 scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
{{-- <script>
    $(document).ready(function() {
        $('#order_id, #nopol, #driver_id, #kenek_id').select2({
            placeholder: 'Select',
            allowClear: true
        });
    });
</script> --}}
@endsection
