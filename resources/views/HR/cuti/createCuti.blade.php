@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Create Rekanan</h1>
    <form method="POST" action="{{ route('pengajuan-cuti.store') }}">
        @csrf

        <div class="mb-4">
            <label for="tanggal_mulai" class="block text-gray-700 font-medium mb-2">{{ __('Tanggal Mulai') }}</label>
            <input id="tanggal_mulai" type="date" class="form-input w-full @error('tanggal_mulai') border-red-500 @enderror" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required autocomplete="tanggal_mulai" autofocus>

            @error('tanggal_mulai')
                <span class="text-red-500 text-sm mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tanggal_akhir" class="block text-gray-700 font-medium mb-2">{{ __('Tanggal Akhir') }}</label>
            <input id="tanggal_akhir" type="date" class="form-input w-full @error('tanggal_akhir') border-red-500 @enderror" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" required autocomplete="tanggal_akhir">

            @error('tanggal_akhir')
                <span class="text-red-500 text-sm mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="alasan" class="block text-gray-700 font-medium mb-2">{{ __('Alasan') }}</label>
            <textarea id="alasan" class="form-textarea w-full @error('alasan') border-red-500 @enderror" name="alasan" rows="4" required autocomplete="alasan">{{ old('alasan') }}</textarea>

            @error('alasan')
                <span class="text-red-500 text-sm mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
            {{ __('Ajukan Cuti') }}
        </button>
    </form>
</div>
@endsection
