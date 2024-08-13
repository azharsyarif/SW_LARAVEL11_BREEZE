@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Create New Rekanan</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rekanan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow-md rounded-lg p-6 mb-4">
            <h2 class="text-lg font-semibold mb-4">Form Data Rekanan</h2>

            <div class="mb-4">
                <label for="nama_pt" class="block text-sm font-medium text-gray-700">Nama PT</label>
                <input type="text" class="form-input mt-1 block w-full @error('nama_pt') border-red-500 @enderror" id="nama_pt" name="nama_pt" value="{{ old('nama_pt') }}" required>
                @error('nama_pt')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="npwp" class="block text-sm font-medium text-gray-700">NPWP</label>
                <input type="text" class="form-input mt-1 block w-full @error('npwp') border-red-500 @enderror" id="npwp" name="npwp" value="{{ old('npwp') }}" required>
                @error('npwp')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="upload_npwp" class="block text-sm font-medium text-gray-700">Upload NPWP</label>
                <input type="file" class="form-input mt-1 block w-full @error('upload_npwp') border-red-500 @enderror" id="upload_npwp" name="upload_npwp" required>
                @error('upload_npwp')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="no_tlp" class="block text-sm font-medium text-gray-700">No Tlp</label>
                <input type="text" class="form-input mt-1 block w-full @error('no_tlp') border-red-500 @enderror" id="no_tlp" name="no_tlp" value="{{ old('no_tlp') }}" required>
                @error('no_tlp')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="jenis_usaha" class="block text-sm font-medium text-gray-700">Jenis Usaha</label>
                <input type="text" class="form-input mt-1 block w-full @error('jenis_usaha') border-red-500 @enderror" id="jenis_usaha" name="jenis_usaha" value="{{ old('jenis_usaha') }}" required>
                @error('jenis_usaha')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea class="form-input mt-1 block w-full @error('alamat') border-red-500 @enderror" id="alamat" name="alamat" rows="4" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="term_agrement" class="block text-sm font-medium text-gray-700">Term Agreement</label>
                <div class="flex">
                    <input type="text" class="form-input mt-1 block w-full @error('term_agrement') border-red-500 @enderror" id="term_agrement" name="term_agrement" value="{{ old('term_agrement') }}">
                    <span class="ml-2 flex items-center text-sm text-gray-600">Hari</span>
                </div>
                @error('term_agrement')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Submit</button>
    </form>
</div>
@endsection
