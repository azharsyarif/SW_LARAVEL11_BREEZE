<?php

namespace App\Http\Controllers;

use App\Models\IntruksiJalan;
use App\Models\Kendaraan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    public function kendaraanIndex(){
        $kendaraans = Kendaraan::all();

        return view('Operasional.Kendaraan.kendaraanIndex', compact('kendaraans'));
    }

    public function viewCreateKendaraan(){
        $intruksiJalans = IntruksiJalan::all();
        $kendaraans = Kendaraan::all();
        $orders = Order::all();
        return view('Operasional.Kendaraan.createKendaraan');
    }
    public function kendaraanStore(Request $request){

        $validator = Validator::make($request->all(), [
            'nopol' => 'required|string',
            'jenis_kendaraan' => 'required|string',
            'panjang' => 'required|string',
            'lebar' => 'required|string',
            'tinggi' => 'required|string',
            'berat_maksimal' => 'required|string',
            'no_rangka' => 'required|string',
            'tanggal_pajak_plat' => 'required|date',
            'tanggal_pajak_stnk' => 'required|date',
        ]);

        if ($validator->fails()){
            return redirect()->route('karyawan.index')
                ->withErrors($validator)
                ->withInput();
        }

        $kendaraan = new Kendaraan();
        $kendaraan->nopol = $request->nopol;
        $kendaraan->jenis_kendaraan = $request->jenis_kendaraan;
        $kendaraan->panjang = $request->panjang;
        $kendaraan->lebar = $request->lebar;
        $kendaraan->tinggi = $request->tinggi;
        $kendaraan->berat_maksimal = $request->berat_maksimal;
        $kendaraan->no_rangka = $request->no_rangka;
        $kendaraan->tanggal_pajak_plat = $request->tanggal_pajak_plat;
        $kendaraan->tanggal_pajak_stnk = $request->tanggal_pajak_stnk;
        $kendaraan->save();
        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil ditambahkan');
    }

    public function editKendaraan($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        return view('Operasional.Kendaraan.editKendaraan', compact('kendaraan'));
    }

    public function updateKendaraan(Request $request, $id)
    {
        $request->validate([
            'nopol' => 'required|string|max:255',
            'jenis_kendaraan' => 'required|string|max:255',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'tinggi' => 'required|numeric',
            'berat_maksimal' => 'required|numeric',
            'no_rangka' => 'required|string|max:255',
            'tanggal_pajak_plat' => 'required|date',
            'tanggal_pajak_stnk' => 'required|date',
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update($request->all());

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }
    public function destroyKendaraan($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
