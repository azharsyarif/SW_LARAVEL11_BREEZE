@extends('layouts.app')

@section('content')
<div class="bg-gray-100 shadow rounded-lg p-4 mb-6">
    <h3 class="text-lg font-medium text-gray-700 mb-4">Invoice Info</h3>
    <p class="text-sm text-gray-600">
        <strong>Dibuat:</strong> {{ $intruksiJalan->created_at->format('d M Y, H:i') }}
    </p>
    <p class="text-sm text-gray-600">
        <strong>Terakhir di Edit:</strong> {{ $intruksiJalan->updated_at->format('d M Y, H:i') }}
    </p>
</div>
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6">Edit Instruksi Jalan</h2>
    <form action="{{ route('instruksi_jalan.update', $intruksiJalan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- No Order -->
        <div class="mb-4">
            <label for="order_id" class="block text-gray-700 font-medium mb-1">No Order</label>
            <select id="order_id" name="order_id" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('order_id') border-red-500 @enderror">
                <option value="">Pilih No Order</option>
                @foreach ($orders as $order)
                    <option value="{{ $order->id }}" {{ $intruksiJalan->order_id == $order->id ? 'selected' : '' }}>{{ $order->formattedOrder() }}</option>
                @endforeach
            </select>
            @error('order_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Driver -->
        <div class="mb-4">
            <label for="driver_id" class="block text-gray-700 font-medium mb-1">Driver</label>
            <select id="driver_id" name="driver_id" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('driver_id') border-red-500 @enderror">
                <option value="">Pilih Driver</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $intruksiJalan->driver_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('driver_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kenek -->
        <div class="mb-4">
            <label for="kenek_id" class="block text-gray-700 font-medium mb-1">Kenek</label>
            <select id="kenek_id" name="kenek_id" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kenek_id') border-red-500 @enderror">
                <option value="">Pilih Kenek</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $intruksiJalan->kenek_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            @error('kenek_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nopol -->
        <div class="mb-4">
            <label for="nopol" class="block text-gray-700 font-medium mb-1">Nopol</label>
            <select id="nopol" name="nopol" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nopol') border-red-500 @enderror">
                <option value="">Pilih Nopol</option>
                @foreach ($kendaraans as $kendaraan)
                    <option value="{{ $kendaraan->nopol }}" {{ $intruksiJalan->nopol == $kendaraan->nopol ? 'selected' : '' }}>{{ $kendaraan->nopol }}</option>
                @endforeach
            </select>
            @error('nopol')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Jalan -->
        <div class="mb-4">
            <label for="tanggal_jalan" class="block text-gray-700 font-medium mb-1">Tanggal Jalan</label>
            <input type="date" id="tanggal_jalan" name="tanggal_jalan" value="{{ $intruksiJalan->tanggal_jalan }}" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_jalan') border-red-500 @enderror">
            @error('tanggal_jalan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Stuffing -->
        <div class="mb-4">
            <label for="tanggal_stuffing" class="block text-gray-700 font-medium mb-1">Tanggal Stuffing (Muat)</label>
            <input type="date" id="tanggal_stuffing" name="tanggal_stuffing" value="{{ $intruksiJalan->tanggal_stuffing }}" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_stuffing') border-red-500 @enderror">
            @error('tanggal_stuffing')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Stripping -->
        <div class="mb-4">
            <label for="tanggal_stripping" class="block text-gray-700 font-medium mb-1">Tanggal Stripping (Bongkar)</label>
            <input type="date" id="tanggal_stripping" name="tanggal_stripping" value="{{ $intruksiJalan->tanggal_stripping }}" class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_stripping') border-red-500 @enderror">
            @error('tanggal_stripping')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estimasi Waktu Ke Tujuan -->
        <div class="mb-4">
            <label for="estimasi_waktu_ke_tujuan" class="block text-gray-700 font-medium mb-1">Estimasi Waktu Ke Tujuan</label>
            <input type="text" id="estimasi_waktu_ke_tujuan" name="estimasi_waktu_ke_tujuan" value="{{ $intruksiJalan->estimasi_waktu_ke_tujuan }}" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('estimasi_waktu_ke_tujuan') border-red-500 @enderror">
            @error('estimasi_waktu_ke_tujuan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estimasi Jarak -->
        <div class="mb-4">
            <label for="estimasi_jarak" class="block text-gray-700 font-medium mb-1">Estimasi Jarak</label>
            <input type="text" id="estimasi_jarak" name="estimasi_jarak" value="{{ $intruksiJalan->estimasi_jarak }}" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('estimasi_jarak') border-red-500 @enderror">
            @error('estimasi_jarak')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
