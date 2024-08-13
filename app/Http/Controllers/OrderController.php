<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Order;
use App\Models\PICCustomer;
use App\Models\POCustomer;
use App\Models\Rekanan;
use App\Services\CityService; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $cityService;

    // Inject CityService into the controller
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function index(Request $request)
    {
        $search_po = $request->input('search_po');
        $perPage = $request->input('per_page', 5);
    
        $orders = Order::when($search_po, function ($query, $search_po) {
            return $query->where('no_po', 'like', '%' . $search_po . '%');
        })->paginate($perPage);
    
        $averageRevenue = Order::select(DB::raw('avg(cast(harga_deal as numeric)) as average'))->value('average');
    
        return view('Marketing.Order.orderIndex', compact('orders', 'averageRevenue'));
    }
    
    public function viewCreate(Request $request)
    {
        $rekanans = Rekanan::all();
        $kendaraans = Kendaraan::all();
        $pics = PICCustomer::all();
        $pOCustomers = POCustomer::all();
        $cities = $this->cityService->fetchCities(); // Use the CityService to fetch cities
        $term_agreement = ''; // Default value for term agreement
    
        return view('Marketing.Order.createOrder', compact('rekanans', 'kendaraans', 'pics', 'pOCustomers', 'cities', 'term_agreement'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_po' => 'required|exists:p_o_customers,id',
            'asal' => 'required|string',
            'tujuan' => 'required|string',
            'total_km' => 'required|numeric',
            'total_koli' => 'required|numeric',
            'total_berat' => 'nullable|numeric',
            'deskripsi_barang' => 'required|string',
            'term_agrement' => 'required|string',
            'layanan' => 'required|in:darat,laut,udara,mobil',
            'kendaraan_id' => 'nullable|exists:kendaraans,id',
            'harga_deal' => 'nullable|numeric',
            'total_harga_deal' => 'nullable|numeric',
            'upload_harga_deal' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        ]);
    
        // Debugging
        Log::info('Validated Data:', $validated);
    
        // Fetch rekanan_id based on the selected no_po
        $poCustomer = POCustomer::find($request->no_po);
        $rekananId = $poCustomer ? $poCustomer->rekanan_id : null;
    
        // Check if rekanan_id is found
        if ($rekananId === null) {
            return redirect()->back()->withErrors(['no_po' => 'Invalid PO Customer selected.']);
        }
    
        // Use a transaction to ensure atomicity
        DB::transaction(function () use ($validated, $rekananId, $request) {
            // Generate No Order
            $noOrder = $this->generateNoOrder();
    
            // Debugging
            Log::info('Order Data:', array_merge($validated, [
                'no_order' => $noOrder,
                'rekanan_id' => $rekananId,
            ]));
    
            // Store the new order
            $order = Order::create(array_merge($validated, [
                'no_order' => $noOrder,
                'rekanan_id' => $rekananId,
            ]));
    
            // Handle file upload if exists
            if ($request->hasFile('upload_harga_deal')) {
                $file = $request->file('upload_harga_deal');
                $filename = $file->store('uploads', 'public');
                $order->upload_harga_deal = $filename;
                $order->save();
            }
        });
    
        return redirect()->route('marketing.order.index')->with('success', 'Order created successfully.');
    }
    
    private function generateNoOrder()
    {
        $prefix = 'ODR-';
        $latestOrder = Order::orderBy('no_order', 'desc')->first();
    
        // Jika tidak ada order sebelumnya
        if (!$latestOrder) {
            return $prefix . '000001';
        }
    
        // Ambil nomor order terakhir dan tambahkan 1
        $lastNoOrder = $latestOrder->no_order;
        $lastOrderNumber = str_replace($prefix, '', $lastNoOrder);
        $nextOrderNumber = str_pad((int) $lastOrderNumber + 1, 6, '0', STR_PAD_LEFT);
    
        return $prefix . $nextOrderNumber;
    }
    

    public function getOrdersByNoPo($id)
    {
        $orders = Order::where('no_po', $id)->get(['no_order', 'tujuan', 'total_harga_deal']);
        $poCustomer = POCustomer::find($id);
        $rekanan = Rekanan::find($poCustomer->rekanan_id);
    
        $totalHargaDeal = $orders->sum('total_harga_deal');
    
        $response = [
            'orders' => $orders,
            'rekanan' => $rekanan,
            'total_harga_deal' => $totalHargaDeal
        ];
    
        Log::info('Order Data:', $response);
    
        return response()->json($response);
    }
    

    




}
