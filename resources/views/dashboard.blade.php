@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Dashboard</h1>
        <h1 class="text-3xl font-medium">Selamat Datang, {{ Auth::user()->name }}</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-medium text-gray-700">Jumlah Pengajuan Cuti</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $jumlahPengajuanCuti }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-medium text-gray-700">Jumlah Pengajuan Izin Sakit</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $jumlahPengajuanIzinSakit }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-medium text-gray-700">Cuti Tersisa</h2>
                <p class="text-2xl font-bold text-gray-900">{{ $cutiTersisa }} Hari</p>
            </div>
        </div>
    </div>
@endsection
