@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-semibold text-gray-800 mb-4">{{ __('Approval Payment Management') }}</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-5xl">
            <div class="bg-white shadow-md rounded-lg">
                <div class="p-6">
                    <ul class="flex border-b mb-4">
                        <li class="mr-1">
                            <a class="inline-block py-2 px-4 {{ $tab == 'pending' ? 'text-blue-500 border-b-2 border-blue-500' : 'text-gray-500' }}"
                                href="{{ route('approvalPayment-index', ['tab' => 'pending']) }}">Pending</a>
                        </li>
                        <li class="mr-1">
                            <a class="inline-block py-2 px-4 {{ $tab == 'approved' ? 'text-blue-500 border-b-2 border-blue-500' : 'text-gray-500' }}"
                                href="{{ route('approvalPayment-index', ['tab' => 'approved']) }}">Approved</a>
                        </li>
                    </ul>

                    @if ($tab == 'pending')
                        <div class="overflow-x-auto">
                            <table id="pendingDataTable" class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b">No Inv</th>
                                        <th class="px-4 py-2 border-b">Term Agreement</th>
                                        <th class="px-4 py-2 border-b">Tanggal Kirim</th>
                                        <th class="px-4 py-2 border-b">Net Income</th>
                                        <th class="px-4 py-2 border-b">Status</th>
                                        <th class="px-4 py-2 border-b">Action</th>
                                        <th class="px-4 py-2 border-b">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unapprovedInvoices as $invoice)
                                        <tr class="cursor-pointer bg-white border-b" data-toggle="collapse" data-target="#invoice-details-{{ $invoice->id }}">
                                            <td class="px-4 py-2 border-b">{{ $invoice->no_inv }}</td>
                                            <td class="px-4 py-2 border-b">{{ $invoice->poCustomer->rekanan->term_agrement ?? 'Tidak Ditemukan' }} Hari</td>
                                            <td class="px-4 py-2 border-b">{{ $invoice->tanggal_kirim_inv }}</td>
                                            <td class="px-4 py-2 border-b">@currency($invoice->net_income)</td>
                                            <td class="px-4 py-2 border-b">
                                                <span class="bg-yellow-400 text-white text-xs font-semibold py-1 px-2 rounded">Pending</span>
                                            </td>
                                            <td class="px-4 py-2 border-b">
                                                <a href="{{ route('approval_payment.create', ['invoice' => $invoice->id]) }}"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm"
                                                    aria-label="Approve payment for invoice {{ $invoice->no_inv }}">
                                                    Approve Payment
                                                </a>
                                            </td>
                                            <td class="px-4 py-2 border-b">
                                                <a href="#" class="text-blue-500 hover:underline" data-toggle="collapse" data-target="#invoice-details-{{ $invoice->id }}">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="invoice-details-{{ $invoice->id }}" class="hidden bg-gray-100">
                                            <td colspan="7" class="px-4 py-4">
                                                <div>
                                                    <h5 class="text-lg font-bold">Detail Invoice:</h5>
                                                    <ul class="list-disc list-inside">
                                                        <li><strong>No PO Customer:</strong> {{ $invoice->poCustomer->no_po ?? 'N/A' }}</li>
                                                        <li><strong>Term Agreement:</strong> {{ $invoice->poCustomer->rekanan->term_agrement ?? 'Tidak Ditemukan' }} Hari</li>
                                                        <li><strong>Tanggal Kirim:</strong> {{ $invoice->tanggal_kirim_inv }}</li>
                                                        <li><strong>Net Income:</strong> @currency($invoice->net_income)</li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($tab == 'approved')
                        <div class="overflow-x-auto">
                            <table id="approvedDataTable" class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b">No Inv</th>
                                        <th class="px-4 py-2 border-b">Term Agreement</th>
                                        <th class="px-4 py-2 border-b">Tanggal Kirim</th>
                                        <th class="px-4 py-2 border-b">Net Income</th>
                                        <th class="px-4 py-2 border-b">Total Pembayaran</th>
                                        <th class="px-4 py-2 border-b">Status</th>
                                        <th class="px-4 py-2 border-b">Upload Bukti Payment</th>
                                        <th class="px-4 py-2 border-b">Dibuat Pada</th>
                                        <th class="px-4 py-2 border-b">Approved By</th>
                                        <th class="px-4 py-2 border-b">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvedInvoices as $invoice)
                                        <tr class="cursor-pointer bg-white border-b" data-toggle="collapse" data-target="#invoice-details-{{ $invoice->id }}">
                                            <td class="px-4 py-2 border-b">{{ $invoice->no_inv }}</td>
                                            <td class="px-4 py-2 border-b">{{ $invoice->poCustomer->rekanan->term_agrement ?? 'Tidak Ditemukan' }}</td>
                                            <td class="px-4 py-2 border-b">{{ $invoice->tanggal_kirim_inv }}</td>
                                            <td class="px-4 py-2 border-b">@currency($invoice->net_income)</td>
                                            <td class="px-4 py-2 border-b">@currency($invoice->payment->total_pembayaran ?? 'Tidak Ada Data')</td>
                                            <td class="px-4 py-2 border-b">
                                                <span class="bg-green-500 text-white text-xs font-semibold py-1 px-2 rounded">Approved</span>
                                            </td>
                                            <td class="px-4 py-2 border-b">
                                                @if ($invoice->payment && $invoice->payment->upload_bukti_payment)
                                                    <a href="{{ asset('storage/' . $invoice->payment->upload_bukti_payment) }}"
                                                        target="_blank" class="text-blue-500 hover:underline"
                                                        aria-label="View payment proof for invoice {{ $invoice->no_inv }}">
                                                        Lihat Dokumen
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 border-b">{{ $invoice->payment->created_at->format('d-m-Y H:i') ?? '-' }}</td>
                                            <td class="px-4 py-2 border-b">{{ $invoice->payment->picApproval->name ?? '-' }}</td>
                                            <td class="px-4 py-2 border-b">
                                                <a href="#" class="text-blue-500 hover:underline" data-toggle="collapse" data-target="#invoice-details-{{ $invoice->id }}">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="invoice-details-{{ $invoice->id }}" class="hidden bg-gray-100">
                                            <td colspan="10" class="px-4 py-4">
                                                <div>
                                                    <h5 class="text-lg font-bold">Detail Invoice:</h5>
                                                    <ul class="list-disc list-inside">
                                                        <li><strong>No PO Customer:</strong> {{ $invoice->poCustomer->no_po ?? 'N/A' }}</li>
                                                        <li><strong>Term Agreement:</strong> {{ $invoice->poCustomer->rekanan->term_agrement ?? 'Tidak Ditemukan' }}</li>
                                                        <li><strong>Tanggal Kirim:</strong> {{ $invoice->tanggal_kirim_inv }}</li>
                                                        <li><strong>Net Income:</strong> @currency($invoice->net_income)</li>
                                                        <li><strong>Total Pembayaran:</strong> @currency($invoice->payment->total_pembayaran ?? 'Tidak Ada Data')</li>
                                                        <li><strong>Dibuat Pada:</strong> {{ $invoice->payment->created_at->format('d-m-Y H:i') ?? '-' }}</li>
                                                        <li><strong>Approved By:</strong> {{ $invoice->payment->picApproval->name ?? '-' }}</li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('a[data-toggle="collapse"]').on('click', function() {
                var target = $(this).data('target');
                $(target).toggleClass('hidden');
            });

            $('#pendingDataTable').DataTable();
            $('#approvedDataTable').DataTable();
        });
    </script>
@endsection
