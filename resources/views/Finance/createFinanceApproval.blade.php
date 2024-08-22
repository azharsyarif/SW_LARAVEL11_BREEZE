@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="bg-gray-800 text-white px-6 py-4">
            Approval Payment untuk Invoice: {{ $invoice->no_inv }}
        </div>
        <div class="p-6">
            <form action="{{ route('approval_payment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="no_inv" class="block text-gray-700 font-semibold">No Inv</label>
                    <input type="text" id="no_inv" name="no_inv" value="{{ $invoice->no_inv }}" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300" readonly>
                </div>
                <div class="mb-4">
                    <label for="total_pembayaran" class="block text-gray-700 font-semibold">Total Pembayaran</label>
                    <input type="text" id="total_pembayaran" name="total_pembayaran" placeholder="Masukkan total pembayaran" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    @if ($errors->has('total_pembayaran'))
                        <span class="text-red-500 text-sm">{{ $errors->first('total_pembayaran') }}</span>
                    @endif
                </div>
                <div class="mb-6">
                    <label for="upload_bukti_payment" class="block text-gray-700 font-semibold">Upload Bukti Payment</label>
                    <input name="upload_bukti_payment[]" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" multiple>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                    Submit
                </button>
            </form>            
        </div>
    </div>
</div>
@endsection
