@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Create New Rekanan</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form for Creating Rekanan -->
    <form action="{{ route('rekanan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6">
        @csrf
        <h2 class="text-xl font-semibold mb-6 text-gray-700">Form Data Rekanan</h2>

        <!-- Nama PT -->
        <div class="mb-6">
            <label for="nama_pt" class="block text-sm font-medium text-gray-700">Nama PT</label>
            <input type="text" id="nama_pt" name="nama_pt" value="{{ old('nama_pt') }}" 
                   class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('nama_pt') border-red-500 @enderror" 
                   required>
            @error('nama_pt')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- NPWP -->
        <div class="mb-6">
            <label for="npwp" class="block text-sm font-medium text-gray-700">NPWP</label>
            <input type="text" id="npwp" name="npwp" value="{{ old('npwp') }}" 
                   class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('npwp') border-red-500 @enderror" 
                   required>
            @error('npwp')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Upload NPWP -->
        <div class="mb-6">
            <label for="upload_npwp" class="block text-sm font-medium text-gray-700">Upload NPWP</label>
            <input type="file" id="upload_npwp" name="upload_npwp" 
                   class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('upload_npwp') border-red-500 @enderror" 
                   required>
            @error('upload_npwp')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- No Tlp -->
        <div class="mb-6">
            <label for="no_tlp" class="block text-sm font-medium text-gray-700">No Tlp</label>
            <input type="text" id="no_tlp" name="no_tlp" value="{{ old('no_tlp') }}" 
                   class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('no_tlp') border-red-500 @enderror" 
                   required>
            @error('no_tlp')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jenis Usaha -->
        <div class="mb-6">
            <label for="jenis_usaha" class="block text-sm font-medium text-gray-700">Jenis Usaha</label>
            <input type="text" id="jenis_usaha" name="jenis_usaha" value="{{ old('jenis_usaha') }}" 
                   class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('jenis_usaha') border-red-500 @enderror" 
                   required>
            @error('jenis_usaha')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Alamat -->
        <div class="mb-6">
            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
            <textarea id="alamat" name="alamat" rows="4" 
                      class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('alamat') border-red-500 @enderror" 
                      required>{{ old('alamat') }}</textarea>
            @error('alamat')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Term Agreement -->
        <div class="mb-6">
            <label for="term_agrement" class="block text-sm font-medium text-gray-700">Term Agreement</label>
            <div class="flex items-center">
                <input type="text" id="term_agrement" name="term_agrement" value="{{ old('term_agrement') }}" 
                       class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm @error('term_agrement') border-red-500 @enderror">
                <span class="ml-2 text-sm text-gray-500">Hari</span>
            </div>
            @error('term_agrement')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection
