<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function indexApprovalPayment(Request $request) {
        // Ambil parameter tab dari query string, default ke 'pending'
        $tab = $request->query('tab', 'pending');
        
        // Ambil semua invoice yang belum di-approve (belum ada payment)
        $unapprovedInvoices = Invoice::whereDoesntHave('payment')->get();
        
        // Ambil semua invoice yang sudah di-approve (sudah ada payment)
        $approvedInvoices = Invoice::whereHas('payment')->get();
        
        // Kembalikan view dengan variabel yang diperlukan
        return view('Finance.financeIndex', compact('unapprovedInvoices', 'approvedInvoices', 'tab'));
    }
    
    
    

    public function createApprovalPayment($invoiceId) {
        $invoice = Invoice::findOrFail($invoiceId);
    
        return view('Finance.createFinanceApproval', compact('invoice'));
    }

    public function storeApprovalPayment(Request $request) {
        $validatedData = $request->validate([
            'no_inv' => 'required|string',
            'total_pembayaran' => 'required|numeric',
            'upload_bukti_payment.*' => 'nullable|file|mimes:jpg,png,pdf', // Validate each file
        ]);
    
        // Ambil invoice berdasarkan no_inv
        $invoice = Invoice::where('no_inv', $validatedData['no_inv'])->firstOrFail();
    
        DB::beginTransaction();
    
        try {
            // Simpan data ke dalam tabel payments
            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'pic_approval_id' => auth()->user()->id, // asumsikan user yang saat ini login adalah PIC
                'tanggal_approval' => now(),
                'net_income' => $invoice->net_income,
                'total_pembayaran' => $validatedData['total_pembayaran'],
            ]);
    
            // Proses setiap file yang diupload
            if ($request->hasFile('upload_bukti_payment')) {
                $files = $request->file('upload_bukti_payment');
                foreach ($files as $file) {
                    $path = $file->store('bukti_payment', 'public');
                    // Simpan path file ke database, Anda bisa menyimpan ke tabel lain jika perlu
                    $payment->upload_bukti_payment = $path; // Atau tambahkan logika lain jika ingin menyimpan banyak file
                    $payment->save();
                }
            }
    
            DB::commit();
    
            return redirect()->route('approvalPayment-index')->with('success', 'Payment Approved Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Failed to approve payment: ' . $e->getMessage());
        }
    }
    
    
    
    public function overdueInvoices(Request $request) {
        $today = \Carbon\Carbon::now();
    
        // Ambil semua invoice dan tambahkan informasi jatuh tempo
        $invoices = Invoice::with('payment', 'poCustomer', 'poCustomer.rekanan')
            ->get()
            ->map(function ($invoice) use ($today) {
                $termDays = (int) ($invoice->poCustomer->rekanan->term_agrement ?? 0);
                $invoiceDate = \Carbon\Carbon::parse($invoice->tanggal_kirim_inv);
                $dueDate = $invoiceDate->addDays($termDays);
    
                $invoice->isOverdue = $today->greaterThan($dueDate);
                $invoice->dueDate = $dueDate;
    
                return $invoice;
            });
    
        // Kelompokkan invoice berdasarkan hari jatuh tempo
        $overdueGroups = [
            'less_than_30_days' => $invoices->filter(function ($invoice) use ($today) {
                return $today->diffInDays($invoice->dueDate) <= 30;
            }),
            'less_than_60_days' => $invoices->filter(function ($invoice) use ($today) {
                return $today->diffInDays($invoice->dueDate) > 30 && $today->diffInDays($invoice->dueDate) <= 60;
            }),
            'less_than_90_days' => $invoices->filter(function ($invoice) use ($today) {
                return $today->diffInDays($invoice->dueDate) > 60 && $today->diffInDays($invoice->dueDate) <= 90;
            }),
            'more_than_90_days' => $invoices->filter(function ($invoice) use ($today) {
                return $today->diffInDays($invoice->dueDate) > 90;
            }),
        ];
    
        // Hitung jumlah invoice di setiap kategori
        $overdueCounts = [
            'less_than_30_days' => $overdueGroups['less_than_30_days']->count(),
            'less_than_60_days' => $overdueGroups['less_than_60_days']->count(),
            'less_than_90_days' => $overdueGroups['less_than_90_days']->count(),
            'more_than_90_days' => $overdueGroups['more_than_90_days']->count(),
        ];
    
        return view('Finance.overdueInvoices', compact('overdueGroups', 'overdueCounts'));
    }
}

