@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Create New Leave Request</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 mb-6 rounded-lg border border-red-200">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pengajuan-cuti.store') }}">
        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Start Date -->
            <div class="mb-4">
                <label for="tanggal_mulai" class="block text-gray-700 font-medium">{{ __('Tanggal Mulai') }}</label>
                <input id="tanggal_mulai" type="date" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_mulai') border-red-500 @enderror" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                @error('tanggal_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Date -->
            <div class="mb-4">
                <label for="tanggal_akhir" class="block text-gray-700 font-medium">{{ __('Tanggal Akhir') }}</label>
                <input id="tanggal_akhir" type="date" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_akhir') border-red-500 @enderror" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" required>
                @error('tanggal_akhir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reason -->
            <div class="mb-4">
                <label for="alasan" class="block text-gray-700 font-medium">{{ __('Alasan') }}</label>
                <textarea id="alasan" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alasan') border-red-500 @enderror" name="alasan" rows="4" required>{{ old('alasan') }}</textarea>
                @error('alasan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                {{ __('Ajukan Cuti') }}
            </button>
        </div>
    </form>
</div>
@endsection
