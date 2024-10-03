@extends('layouts.app')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ __('Order Management') }}</h1>

        <div class="flex justify-center">
            @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4 relative" id="success-alert">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 p-2 text-white" onclick="document.getElementById('success-alert').remove();">
                    &times;
                </button>
            </div>
        @endif
            <div class="w-full max-w-6xl bg-white shadow-lg rounded-lg">
                <div class="p-6">

                    <!-- Stats Section -->
                    <div class="grid grid-cols-1 gap-4 mb-6">
                        <div class="bg-white border-b border-gray-200 p-4">
                            <h6 class="text-lg font-bold text-blue-600">Total Orders</h6>
                            <p class="mt-2 text-xl font-bold">{{ $orders->count() }}</p>
                        </div>
                        <div class="bg-white border-b border-gray-200 p-4">
                            <h6 class="text-lg font-bold text-blue-600">Average Revenue</h6>
                            <p class="mt-2 text-xl font-bold">@currency($averageRevenue)</p>
                        </div>
                    </div>

                    <!-- Filter and Search -->
                    <div class="bg-white p-4 mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h6 class="text-lg font-bold text-blue-600">Filter No. PO</h6>
                            <a href="/order-view-create" id="btnTambahData" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded">Tambah Data</a>
                        </div>
                        <form action="{{ route('marketing.order.index') }}" method="GET" class="mb-4">
                            <div class="flex items-center mb-3">
                                <input type="text" id="search_po" name="search_po" value="{{ request('search_po') }}" placeholder="Search PO..." class="form-input w-full mr-2">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
                                @if (request()->has('search_po'))
                                    <a href="{{ route('marketing.order.index') }}" class="ml-2 bg-gray-300 text-gray-700 px-4 py-2 rounded">X</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Orders Table -->
                    <div class="bg-white p-4 mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
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

                        <!-- Pagination with Per Page Selector -->
                        <div class="flex items-center justify-between mt-4">
                            <div>
                                <label for="per_page" class="block text-gray-700">Show per page:</label>
                                <form action="{{ route('marketing.order.index') }}" method="GET" class="inline">
                                    <select id="per_page" name="per_page" class="form-select" onchange="this.form.submit()">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    </select>
                                </form>
                            </div>
                            <div>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Add Data Form -->
            <div class="bg-white p-6 rounded-lg shadow mt-6" id="formTambahData" style="{{ $errors->any() ? 'display: block;' : 'display: none;' }}">
                <!-- Form content here -->
            </div>
        </div>
    </div>
@endsection
