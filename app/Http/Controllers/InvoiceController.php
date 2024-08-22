<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\POCustomer;
use App\Models\Rekanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Get the per_page parameter from the request, default to 5 if not provided
        $perPage = $request->input('per_page', 5);
    
        // Get the search term from the request
        $searchNoPo = $request->input('search_no_po');
    
        // Query invoices with optional search and pagination
        $query = Invoice::query();
    
        if ($searchNoPo) {
            $query->whereHas('poCustomer', function ($query) use ($searchNoPo) {
                $query->where('no_po', 'like', "%{$searchNoPo}%");
            });
        }
    
        $invoices = $query->paginate($perPage);
    
        // Transform the items in the current page
        $invoices->getCollection()->transform(function($invoice) {
            $invoice->tanggal_kirim_inv = Carbon::parse($invoice->tanggal_kirim_inv);
            return $invoice;
        });
    
        // Calculate the average revenue
        $averageRevenue = Invoice::select(DB::raw('avg(cast(revenue as numeric)) as average'))->value('average');
    
        // Fetch orders and rekanans without pagination (optional)
        $orders = Order::all();
        $rekanans = Rekanan::all();
    
        return view('Marketing.Invoice.invoiceIndex', compact('invoices', 'orders', 'rekanans', 'averageRevenue'));
    }
    
    public function viewCreate()
    {
        $rekanans = Rekanan::all(); // Fetch rekanans data
        $po_customers = POCustomer::all();
        return view('Marketing.Invoice.createInvoice', compact('po_customers','rekanans'));
    }
    public function getOrders(Request $request)
    {
        $poCustomerId = $request->query('po_customer_id');
    
        // Fetch orders related to no_po
        $orders = Order::with('rekanan') // Eager load rekanan
            ->where('no_po', $poCustomerId)
            ->get();
    
        if ($orders->isEmpty()) {
            return response()->json([
                'orders' => [],
                'term_agreement' => 'N/A' 
            ]);
        }
    
        $termAgreement = $orders->first()->rekanan->term_agrement ?? 'N/A';
    
        $ordersWithTerms = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'no_order' => $order->no_order,
                'tujuan' => $order->tujuanCity(), // Assuming tujuanCity returns the city name
                'harga_deal' => $order->harga_deal,
                'term_agreement' => $order->rekanan->term_agrement ?? 'N/A',
            ];
        });
    
        return response()->json([
            'orders' => $ordersWithTerms,
            'term_agreement' => $termAgreement
        ]);
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'no_po_customer' => 'required',
            'order_ids' => 'required|array',
            'tanggal_kirim_inv' => 'required|date',
            'biaya_operasional' => 'required|string',
            'revenue' => 'required|string',
            'net_income' => 'required|string',
        ]);
    
        // Clean and convert currency strings to numeric values
        $biayaOperasional = $this->convertCurrencyToNumeric($request->biaya_operasional);
        $revenue = $this->convertCurrencyToNumeric($request->revenue);
        $netIncome = $this->convertCurrencyToNumeric($request->net_income);
    
        DB::beginTransaction();
    
        try {
            // Lock the invoices table to prevent race conditions
            $latestInvoice = DB::table('invoices')->lockForUpdate()->latest()->first();
    
            $latestNoInv = $latestInvoice ? $latestInvoice->no_inv : 'INV-000000';
            $noInv = 'INV-' . str_pad((int) substr($latestNoInv, 4) + 1, 6, '0', STR_PAD_LEFT);
    
            $invoice = Invoice::create([
                'no_po_customer' => $request->no_po_customer,
                'no_inv' => $noInv,
                'tanggal_kirim_inv' => $request->tanggal_kirim_inv,
                'biaya_operasional' => $biayaOperasional,
                'revenue' => $revenue,
                'net_income' => $netIncome,
            ]);
    
            // Attach orders if needed
            if ($request->has('order_ids')) {
                $invoice->orders()->attach($request->order_ids);
            }
    
            DB::commit();
    
            return redirect()->route('marketing.invoice.index')->with('success', 'Invoice created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()->back()->withErrors('Failed to create invoice: ' . $e->getMessage());
        }
    }
    
    
    private function convertCurrencyToNumeric($value)
    {
        // Remove currency symbol and dots
        $numericValue = str_replace(['Rp', '.', ','], ['', '', '.'], $value);
        // Convert to float
        return (float) $numericValue;
    }
    

}
