@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-4">Detail Invoice</h2>
    <div class="bg-gray-100 shadow rounded-lg p-4 mb-6">
        <h3 class="text-lg font-medium text-gray-700 mb-4">Invoice Info</h3>
        <p class="text-sm text-gray-600">
            <strong>Dibuat:</strong> {{ $invoice->created_at->format('d M Y, H:i') }}
        </p>
        <p class="text-sm text-gray-600">
            <strong>Terakhir di Edit:</strong> {{ $invoice->updated_at->format('d M Y, H:i') }}
        </p>
    </div>
    <div class="bg-white shadow rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold mb-2">Invoice Details</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p><strong>No Invoice:</strong> {{ $invoice->no_inv }}</p>
                <p><strong>No PO Customer:</strong> {{ $invoice->poCustomer ? $invoice->poCustomer->no_po : 'N/A' }}</p>
                <p><strong>Tanggal Kirim Invoice:</strong> {{ $invoice->tanggal_kirim_inv->format('Y-m-d') }}</p>
                <p><strong>Term Agreement:</strong> {{ $invoice->term_agreement }} Hari</p>
                <p><strong>Biaya Operasional:</strong> @currency($invoice->biaya_operasional)</p>
                <p><strong>Revenue:</strong> @currency($invoice->revenue)</p>
                <p><strong>Net Income:</strong> @currency($invoice->net_income)</p>
                <p><strong>Dibuat:</strong> {{ $invoice->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
            <div>
                <a href="{{ route('marketing.invoice.edit', $invoice->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Edit Invoice</a>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-2">Orders</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-4 py-2 text-left">No Order</th>
                        <th class="px-4 py-2 text-left">Tujuan</th>
                        <th class="px-4 py-2 text-left">Harga Deal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->orders as $order)
                        <tr class="bg-white border-b">
                            <td class="px-4 py-2">{{ $order->no_order }}</td>
                            <td class="px-4 py-2">{{ $order->tujuanCity() }}</td>
                            <td class="px-4 py-2">@currency($order->harga_deal)</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
