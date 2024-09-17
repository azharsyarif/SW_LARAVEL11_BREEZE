@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold mb-6">Edit Invoice</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('marketing.invoice.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="no_po_customer" class="block text-sm font-medium text-gray-700">PO Customer Number</label>
            <select name="no_po_customer" id="no_po_customer" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select PO Customer</option>
                @foreach($po_customers as $po_customer)
                    <option value="{{ $po_customer->id }}" {{ $invoice->no_po_customer == $po_customer->id ? 'selected' : '' }}>{{ $po_customer->no_po }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">No Order</label>
            <div id="order_ids_container" class="mt-2 space-y-2">

            </div>
        </div>

        <div class="mb-6">
            <label for="term_agreement" class="block text-sm font-medium text-gray-700">Term Agreement</label>
            <div class="flex items-center mt-1">
                <input type="text" name="term_agreement" id="term_agreement" class="form-input block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('term_agreement', $invoice->orders->first()->rekanan->term_agrement ?? 'N/A') }}" disabled>
                <span class="ml-2 text-sm">Hari</span>
            </div>
        </div>

        <div class="mb-6">
            <label for="tanggal_kirim_inv" class="block text-sm font-medium text-gray-700">Tanggal Pengiriman Invoice</label>
            <input type="date" name="tanggal_kirim_inv" id="tanggal_kirim_inv" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('tanggal_kirim_inv', $invoice->tanggal_kirim_inv ? $invoice->tanggal_kirim_inv->format('Y-m-d') : '') }}">
        </div>

        <div class="mb-6">
            <label for="biaya_operasional" class="block text-sm font-medium text-gray-700">Biaya Operasional</label>
            <input type="text" name="biaya_operasional" id="biaya_operasional" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('biaya_operasional', 'Rp. ' . number_format($invoice->biaya_operasional, 0, ',', '.')) }}">
        </div>

        <div class="mb-6">
            <label for="revenue" class="block text-sm font-medium text-gray-700">Revenue</label>
            <input type="text" name="revenue" id="revenue" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('revenue', 'Rp. ' . number_format($invoice->revenue, 0, ',', '.')) }}" readonly>
        </div>

        <div class="mb-6">
            <label for="net_income" class="block text-sm font-medium text-gray-700">Net Income</label>
            <input type="text" name="net_income" id="net_income" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('net_income', 'Rp. ' . number_format($invoice->net_income, 0, ',', '.')) }}" readonly>
        </div>


        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update Invoice</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#no_po_customer').change(function() {
        var poCustomerId = $(this).val();

        if (!poCustomerId) {
            $('#order_ids_container').empty();
            $('#term_agreement').val('');
            updateNetIncome();
            return;
        }

        $.ajax({
            url: '{{ route('api.get-orders') }}',
            type: 'GET',
            data: { po_customer_id: poCustomerId },
            success: function(response) {
                $('#order_ids_container').empty();
                if (response.orders.length > 0) {
                    $.each(response.orders, function(key, order) {
                        var checked = {{ json_encode($selectedOrderIds) }}.includes(order.id) ? 'checked' : '';
                        var checkbox = '<div class="flex items-center">' +
                            '<input class="form-check-input order-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded" type="checkbox" value="' + order.id + '" data-harga-deal="' + order.harga_deal + '" name="order_ids[]" ' + checked + '>' +
                            '<label class="ml-2 block text-sm text-gray-700">' + order.no_order + ' - ' + order.tujuan + '</label>' +
                            '</div>';
                        $('#order_ids_container').append(checkbox);
                    });
                    $('#term_agreement').val(response.term_agreement);
                } else {
                    $('#order_ids_container').append('<p class="text-sm text-gray-500">No orders found for this PO Customer.</p>');
                    $('#term_agreement').val('');
                }
                updateNetIncome();
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
            }
        });
    });

    function formatRupiah(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateNetIncome() {
        var revenue = parseFloat($('#revenue').val().replace(/[^0-9]/g, ''));
        var biayaOperasional = parseFloat($('#biaya_operasional').val().replace(/[^0-9]/g, ''));
        var netIncome = revenue - biayaOperasional;
        $('#net_income').val('Rp ' + formatRupiah(netIncome));
    }
});

</script>
@endsection
