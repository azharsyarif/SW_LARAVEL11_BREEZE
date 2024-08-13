@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Create PO Customer</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('marketing.po.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nama_pt" class="block text-sm font-medium text-gray-700">Nama PT</label>
                        <select name="nama_pt" id="nama_pt" class="form-select mt-1 block w-full @error('nama_pt') border-red-500 @enderror" required>
                            <option value="" disabled selected>Select PT</option>
                            @foreach ($rekanans as $rekanan)
                                <option value="{{ $rekanan->id }}">{{ $rekanan->nama_pt }}</option>
                            @endforeach
                        </select>
                        @error('nama_pt')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="4" class="form-textarea mt-1 block w-full @error('alamat') border-red-500 @enderror" required></textarea>
                        @error('alamat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="PICCustomer" class="block text-sm font-medium text-gray-700">PIC Customer</label>
                        <select name="PICCustomer" id="PICCustomer" class="form-select mt-1 block w-full @error('PICCustomer') border-red-500 @enderror" required>
                            <option value="" disabled selected>Select PIC</option>
                            @foreach ($pics as $pic)
                                <option value="{{ $pic->id }}">{{ $pic->nama }}</option>
                            @endforeach
                        </select>
                        @error('PICCustomer')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
