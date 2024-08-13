<?php

namespace App\Http\Controllers;

use App\Models\PICCustomer;
use App\Models\Rekanan;
use Illuminate\Http\Request;

class PICController extends Controller
{
    public function index(){
        $rekanans = PICCustomer::all();


        return view('Rekanan.pic.picIndex', compact('rekanans'));
    }

    public function viewCreate()
    {
        $rekanans = Rekanan::all();
        return view('Rekanan.pic.picCreate', compact('rekanans'));
    }

    public function create(Request $request){
        $request->validate([
            'nama_pt' => 'required|exists:rekanans,id',
            'nama' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:15',
            'posisi' => 'required|string|max:255',
            'cabang' => 'required|string|max:255',
        ]);
    
        PICCustomer::create([
            'nama_pt' => $request->nama_pt,
            'nama' => $request->nama,
            'no_tlp' => $request->no_tlp,
            'posisi' => $request->posisi,
            'cabang' => $request->cabang,
        ]);

        return redirect()->route('pic.index')->with('success', 'PIC Customer berhasil ditambahkan');

    }

    public function delete($id){
        $pic = PICCustomer::findOrFail($id);
        $pic->delete();
        return redirect()->route('pic.index')->with('success', 'PIC Customer berhasil di hapus');
    }
}
