<?php

namespace App\Http\Controllers;

use App\Models\Rekanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekananController extends Controller
{
    public function index()
    {
        $rekanan = Rekanan::all();
        return view('Rekanan.rekanan.rekananIndex', compact('rekanan'));
    }

    public function viewCreate()
    {
        $rekanans = Rekanan::all();
        return view('Rekanan.rekanan.rekananCreate', compact('rekanans'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_pt' => 'required|string',
        'npwp' => 'required|string',
        'no_tlp' => 'required|string|max:15',
        'jenis_usaha' => 'required|string',
        'alamat' => 'required|string',
        'upload_npwp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk file gambar
        'term_agrement' => 'required|string',
    ]);

    // Upload dokumen
    $uploadDokumen = $request->file('upload_npwp');
    $uploadPath = $uploadDokumen ? $uploadDokumen->store('uploads', 'public') : null;

    $rekanan = new Rekanan();
    $rekanan->nama_pt = $request->nama_pt;
    $rekanan->npwp = $request->npwp;
    $rekanan->no_tlp = $request->no_tlp;
    $rekanan->jenis_usaha = $request->jenis_usaha;
    $rekanan->alamat = $request->alamat;
    $rekanan->upload_npwp = $uploadPath; // Simpan path relatif file
    $rekanan->term_agrement = $request->term_agrement;
    $rekanan->save();

    return redirect()->route('rekanan.index')->with('success', 'Data rekanan berhasil ditambahkan');
}
    public function delete($id){
        $rekanan = Rekanan::findOrFail($id);
    
        if ($rekanan->upload_npwp) {
            Storage::disk('public')->delete($rekanan->upload_npwp);
        }
    
        $rekanan->delete();
        return redirect()->route('rekanan.index')->with('success','data rekanan berhasil di hapus');
    }
}
