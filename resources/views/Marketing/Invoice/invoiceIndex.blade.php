@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <h1 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Invoice Management') }}</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-5xl">
            <!-- Pencarian PO Customer -->
            <form action="{{ route('marketing.invoice.index') }}" method="GET" class="mb-4">
                <div class="mb-4">
                    <label for="search_no_po" class="block text-gray-700">Cari berdasarkan No PO Customer</label>
                    <input type="text" name="search_no_po" id="search_no_po" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Masukkan nomor PO" value="{{ request()->input('search_no_po') }}" pattern="\d*">
                    <small class="text-gray-500">Hanya angka yang diperbolehkan.</small><br>
                    <small class="text-gray-500">Contoh : 000004</small>
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Cari</button>
            </form>

            <!-- Tabel Invoices -->
            <div class="bg-white shadow rounded-lg mb-4">
                <div class="p-4">
                    <a href="{{ route('marketing.invoice.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md mb-4 inline-block">Tambah Data</a>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="px-4 py-2 text-left">No Invoice</th>
                                    <th class="px-4 py-2 text-left">No Order</th>
                                    <th class="px-4 py-2 text-left">No PO Customer</th>
                                    <th class="px-4 py-2 text-left">Tanggal Kirim Invoice</th>
                                    <th class="px-4 py-2 text-left">Term Agreement</th>
                                    <th class="px-4 py-2 text-left">Biaya Operasional</th>
                                    <th class="px-4 py-2 text-left">Revenue</th>
                                    <th class="px-4 py-2 text-left">Net Income</th>
                                    <th class="px-4 py-2 text-left">Dibuat</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr class="cursor-pointer bg-white border-b" data-toggle="collapse" data-target="#order-details-{{ $invoice->id }}">
                                        <td class="px-4 py-2">{{ $invoice->no_inv }}</td>
                                        <td class="px-4 py-2 text-blue-500">Klik untuk melihat No Order <i class="fas fa-chevron-down"></i></td>
                                        <td class="px-4 py-2">{{ $invoice->poCustomer ? $invoice->poCustomer->no_po : 'N/A' }}</td>
                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($invoice->tanggal_kirim_inv)->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">{{ $invoice->orders->first()->rekanan->term_agrement ?? 'N/A' }} Hari</td>
                                        <td class="px-4 py-2">@currency($invoice->biaya_operasional)</td>
                                        <td class="px-4 py-2">@currency($invoice->revenue)</td>
                                        <td class="px-4 py-2">@currency($invoice->net_income)</td>
                                        <td class="px-4 py-2">{{ $invoice->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                    <tr id="order-details-{{ $invoice->id }}" class="hidden bg-gray-50">
                                        <td colspan="10" class="p-4">
                                            <h5 class="font-semibold">Orders:</h5>
                                            <ul class="list-disc list-inside">
                                                @foreach ($invoice->orders as $order)
                                                    <li class="py-2">
                                                        <strong>No Order:</strong> {{ $order->no_order }} <br>
                                                        <strong>Tujuan:</strong> {{ $order->tujuanCity() }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>                                                  
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Tabel Invoices -->

            <!-- Pagination -->
            <div class="flex justify-center mt-4">
                {{ $invoices->appends(['search_no_po' => request()->input('search_no_po')])->links() }}
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Toggle collapse
        $('tr[data-toggle="collapse"]').on('click', function () {
            var target = $(this).data('target');
            $(target).toggleClass('hidden');
            $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
        });
    });
</script>
