@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Create PO Customer</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-4 mb-6 rounded-lg border border-red-200">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('marketing.po.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <!-- Nama PT -->
            <div class="mb-4">
                <label for="nama_pt" class="block text-gray-700 font-medium">Nama PT</label>
                <select name="nama_pt" id="nama_pt" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_pt') border-red-500 @enderror" required>
                    <option value="" disabled selected>Select PT</option>
                    @foreach ($rekanans as $rekanan)
                        <option value="{{ $rekanan->id }}">{{ $rekanan->nama_pt }}</option>
                    @endforeach
                </select>
                @error('nama_pt')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 font-medium">Alamat</label>
                <textarea name="alamat" id="alamat" rows="4" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PIC Customer -->
            <div class="mb-4">
                <label for="PICCustomer" class="block text-gray-700 font-medium">PIC Customer</label>
                <select name="PICCustomer" id="PICCustomer" class="mt-1 w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('PICCustomer') border-red-500 @enderror" required>
                    <option value="" disabled selected>Select PIC</option>
                    @foreach ($pics as $pic)
                        <option value="{{ $pic->id }}">{{ $pic->nama }}</option>
                    @endforeach
                </select>
                @error('PICCustomer')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Submit</button>
        </div>
    </form>
</div>
@endsection
