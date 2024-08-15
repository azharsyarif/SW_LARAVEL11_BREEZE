@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-4">Create Invoice</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="no_po_customer" class="block text-sm font-medium text-gray-700">PO Customer Number</label>
            <select name="no_po_customer" id="no_po_customer" class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Select PO Customer</option>
                @foreach($po_customers as $po_customer)
                    <option value="{{ $po_customer->id }}">{{ $po_customer->no_po }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">No Order</label>
            <div id="order_ids_container" class="mt-2 space-y-2">
                <!-- Orders will be loaded here -->
            </div>
        </div>

        <div class="mb-4">
            <label for="term_agreement" class="block text-sm font-medium text-gray-700">Term Agreement</label>
            <div class="flex items-center mt-1">
                <input type="text" name="term_agreement" id="term_agreement" class="form-input block w-full sm:text-sm border-gray-300 rounded-md" disabled>
                <span class="ml-2 text-sm">Hari</span>
            </div>
        </div>

        <div class="mb-4">
            <label for="tanggal_kirim_inv" class="block text-sm font-medium text-gray-700">Tanggal Pengiriman Invoice</label>
            <input type="date" name="tanggal_kirim_inv" id="tanggal_kirim_inv" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="biaya_operasional" class="block text-sm font-medium text-gray-700">Biaya Operasional</label>
            <input type="text" name="biaya_operasional" id="biaya_operasional" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="mb-4">
            <label for="revenue" class="block text-sm font-medium text-gray-700">Revenue</label>
            <input type="text" name="revenue" id="revenue" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>
        </div>

        <div class="mb-4">
            <label for="net_income" class="block text-sm font-medium text-gray-700">Net Income</label>
            <input type="text" name="net_income" id="net_income" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create Invoice</button>
    </form>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#no_po_customer').change(function() {
            var poCustomerId = $(this).val();

            if (!poCustomerId) {
                $('#order_ids_container').empty();
                $('#term_agreement').val('');
                $('#revenue').val('');
                updateNetIncome();
                return;
            }

            $.ajax({
                url: '{{ route('api.get-orders') }}',
                type: 'GET',
                data: { po_customer_id: poCustomerId },
                success: function(response) {
                    console.log('Orders Response:', response);
                    $('#order_ids_container').empty();
                    if (response.orders.length > 0) {
                        $.each(response.orders, function(key, order) {
                            console.log('Order:', order);
                            var checkbox = '<div class="flex items-center">' +
                                '<input class="form-check-input order-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded" type="checkbox" value="' + order.id + '" data-harga-deal="' + order.harga_deal + '" name="order_ids[]">' +
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
                    console.log('AJAX Error:', xhr.responseText);
                }
            });
        });

        $(document).on('change', '.order-checkbox', function() {
            var totalRevenue = 0;
            $('.order-checkbox:checked').each(function() {
                var hargaDeal = $(this).data('harga-deal');
                console.log('Checked Order:', hargaDeal);
                if (hargaDeal) {
                    hargaDeal = parseFloat(hargaDeal.toString().replace(',', '.'));
                    if (!isNaN(hargaDeal)) {
                        totalRevenue += hargaDeal;
                    }
                }
            });
            console.log('Total Revenue:', totalRevenue);
            $('#revenue').val(formatRupiah(totalRevenue.toFixed(2)));
            updateNetIncome();
        });

        $('#biaya_operasional').on('input', function() {
            $(this).val(formatRupiah($(this).val()));
            updateNetIncome();
        });

        function updateNetIncome() {
            var revenue = parseFloat($('#revenue').val().replace(/[^0-9.-]+/g,"")) || 0;
            var operationalCost = parseFloat($('#biaya_operasional').val().replace(/[^0-9.-]+/g,"")) || 0;
            var netIncome = revenue - operationalCost;
            $('#net_income').val(formatRupiah(netIncome.toFixed(2)));
        }

        function formatRupiah(value, prefix = 'Rp ') {
            var number_string = value.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

    });
</script>
