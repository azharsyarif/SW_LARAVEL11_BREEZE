<?php

namespace App\Http\Controllers;

use App\Models\PICCustomer;
use App\Models\POCustomer;
use App\Models\Rekanan;
use Illuminate\Http\Request;

class POController extends Controller
{
    public function index()
    {
        // Ambil semua data PO Customer dari model POCustomer
        $poCustomers = POCustomer::all();

        // Kembalikan view 'marketing.poCustomer.poCustomer' dengan membawa data $pocust
        return view('Marketing.POCustomer.poIndex', compact('poCustomers'));
    }

    public function viewCreate()
    {
        $rekanans = Rekanan::all();
        $pics = PICCustomer::all();

        return view('Marketing.POCustomer.createPO', compact('rekanans', 'pics'));
    }

// Method to generate a unique PO number
private function generateNoPO()
{
    $latestPO = POCustomer::latest()->first();
    if ($latestPO) {
        $lastNumber = intval(substr($latestPO->no_po, -6));
        $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '000001';
    }
    
    return 'PO-' . date('Y') . '-' . $newNumber;
}

public function store(Request $request)
{
    $request->validate([
        'nama_pt' => 'required|exists:rekanans,id',
        'alamat' => 'required|string',
        'PICCustomer' => 'required|exists:p_i_c_customers,id',
    ]);

    // Generate no_po
    $no_po = $this->generateNoPO();

    // Create the POCustomer
    POCustomer::create([
        'no_po' => $no_po,
        'rekanan_id' => $request->nama_pt, // Use 'nama_pt' instead of 'rekanan_id'
        'alamat' => $request->alamat,
        'pic_customer_id' => $request->PICCustomer, // Use 'PICCustomer' instead of 'pic_customer_id'
    ]);

    return redirect()->route('marketing.po.index')->with('success', 'PO Customer created successfully.');
}





    public function viewEdit($id)
    {
        $poCustomer = POCustomer::findOrFail($id);
        $rekanans = Rekanan::all();
        $picCustomers = PICCustomer::all();
        return view('marketing.poCustomer.crud.edit', compact('poCustomer', 'rekanans', 'picCustomers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pt' => 'required|exists:rekanans,id',
            'alamat' => 'required|string',
            'PICCustomer' => 'required|exists:p_i_c_customers,id',
        ]);
    
        $poCustomer = POCustomer::findOrFail($id);
    
        $poCustomer->update([
            'nama_pt' => $request->nama_pt,
            'alamat' => $request->alamat,
            'pic_customer_id' => $request->PICCustomer, // Make sure this is the correct foreign key column name
        ]);
    
        return redirect()->route('marketing.po.index')->with('success', 'PO Customer updated successfully.');
    }    

    public function destroy($id)
    {
        $poCustomer = POCustomer::findOrFail($id);
        $poCustomer->delete();

        return redirect()->route('marketing.po.index')->with('success', 'PO Customer deleted successfully.');
    }
}
