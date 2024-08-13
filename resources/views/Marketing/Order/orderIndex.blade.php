@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Order Management') }}</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-6xl">
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="p-6">
                    <div class="bg-white border-b border-gray-200 p-4">
                        <h6 class="text-lg font-bold text-blue-600">Total Orders</h6>
                        <p class="mt-2 text-xl font-bold">{{ $orders->count() }}</p>
                    </div>
                    <div class="bg-white border-b border-gray-200 p-4 mt-4">
                        <h6 class="text-lg font-bold text-blue-600">Average Revenue</h6>
                        <p class="mt-2 text-xl font-bold">@currency($averageRevenue)</p>
                    </div>
                    
                    <div class="bg-white p-4 mt-4">
                        <div class="flex items-center justify-between mb-4">
                            <h6 class="text-lg font-bold text-blue-600">Filter No. PO</h6>
                            <a href="/order-view-create" id="btnTambahData" class="btn bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded">Tambah Data</a>
                        </div>
                        <form action="{{ route('marketing.order.index') }}" method="GET" class="mb-4">
                            <div class="flex items-center">
                                <input type="text" class="form-input w-full" id="search_po" name="search_po" value="{{ request('search_po') }}" placeholder="Search PO...">
                                <button type="submit" class="ml-2 bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
                                @if (request()->has('search_po'))
                                    <a href="{{ route('marketing.order.index') }}" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded">X</a>
                                @endif
                            </div>
                            <div class="mt-3">
                                <label for="per_page" class="block text-gray-700">Show per page:</label>
                                <select class="form-select w-full mt-1" id="per_page" name="per_page" onchange="this.form.submit()">
                                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                </select>
                            </div>
                        </form>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white rounded-lg shadow">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="px-4 py-2">NO ORDER</th>
                                        <th class="px-4 py-2">NO PO</th>
                                        <th class="px-4 py-2">ASAL</th>
                                        <th class="px-4 py-2">TUJUAN</th>
                                        <th class="px-4 py-2">JENIS LAYANAN</th>
                                        <th class="px-4 py-2">NAMA PERUSAHAAN</th>
                                        <th class="px-4 py-2">TERM AGREEMENT</th>
                                        <th class="px-4 py-2">TOTAL HARGA DEAL</th>
                                        <th class="px-4 py-2">TANGGAL ORDER</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $order->no_order }}</td>
                                            <td class="px-4 py-2">{{ $order->poCustomer->no_po }}</td>
                                            <td class="px-4 py-2">{{ $order->asalCity() }}</td>
                                            <td class="px-4 py-2">{{ $order->tujuanCity() }}</td>
                                            <td class="px-4 py-2">{{ $order->layanan }}</td>
                                            <td class="px-4 py-2">{{ $order->rekanan->nama_pt }}</td>
                                            <td class="px-4 py-2">{{ $order->rekanan->term_agrement }} Hari</td>
                                            <td class="px-4 py-2">@currency($order->total_harga_deal)</td>
                                            <td class="px-4 py-2">{{ $order->created_at->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow mt-6" id="formTambahData" @if ($errors->any()) style="display: block;" @else style="display: none;" @endif>
                <!-- Form content here -->
            </div>
        </div>
    </div>
@endsection
