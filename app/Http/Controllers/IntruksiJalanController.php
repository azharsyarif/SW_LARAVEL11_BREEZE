<?php

namespace App\Http\Controllers;

use App\Models\Divisions;
use App\Models\IntruksiJalan;
use App\Models\Kendaraan;
use App\Models\Order;
use App\Models\User;
use App\Services\CityService;
use Illuminate\Http\Request;
use Matrix\Operators\Division;

class IntruksiJalanController extends Controller
{
    public function instruksiJalanIndex()
    {
        $intruksiJalans = IntruksiJalan::all(); // Ambil semua data Instruksi Jalan
        $kendaraans = Kendaraan::all(); // Ambil semua data Kendaraan
        $orders = Order::all(); // Ambil semua data Order

        return view('Operasional.intruksiJalan.intruksiJalanIndex', compact('intruksiJalans', 'kendaraans', 'orders'));
    }
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function viewCreateIntruksiJalan()
    {
        // Tampilkan form untuk membuat Intruksi Jalan baru
        $kendaraans = Kendaraan::all();
        $orders = Order::all();
        $cities = $this->cityService->fetchCities();
        $operationalDivisionId = Divisions::where('name', 'operasional')->first()->id; // Get the ID of the operational division
        $users = User::whereHas('divisions', function ($query) use ($operationalDivisionId) {
            $query->where('divisions.id', $operationalDivisionId);
        })->get();

        return view('Operasional.intruksiJalan.createIntruksi', compact('kendaraans', 'orders','users','cities'));
    }

    public function store(Request $request)
{
    // Validasi data yang dimasukkan
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'driver_id' => 'required|exists:users,id',
        'kenek_id' => 'nullable|exists:users,id',
        'nopol' => 'required|string|max:20',
        'tanggal_jalan' => 'required|date',
        'estimasi_waktu_ke_tujuan' => 'required|integer',
        'estimasi_jarak' => 'required|integer',
    ]);

    // Auto-generate No Surat Jalan
    $lastInstruksi = IntruksiJalan::orderBy('id', 'desc')->first();
    $nextNumber = $lastInstruksi ? $lastInstruksi->id + 1 : 1; // Tentukan ID berikutnya
    $noSuratJalan = 'SJ-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT); // Membuat format No Surat Jalan

    // Simpan data ke dalam database
    IntruksiJalan::create([
        'no_surat_jalan' => $noSuratJalan,
        'order_id' => $request->order_id,
        'driver_id' => $request->driver_id,
        'kenek_id' => $request->kenek_id,
        'nopol' => $request->nopol,
        'tanggal_jalan' => $request->tanggal_jalan,
        'estimasi_waktu_ke_tujuan' => $request->estimasi_waktu_ke_tujuan,
        'estimasi_jarak' => $request->estimasi_jarak,
        // Tambahkan field lain yang diperlukan
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('intruksiJalan.index')->with('success', 'Instruksi Jalan berhasil ditambahkan.');
}


    public function edit($id)
    {
        // Tampilkan form untuk mengedit Intruksi Jalan
        $intruksiJalan = IntruksiJalan::findOrFail($id);
        $kendaraans = Kendaraan::all();
        $orders = Order::all();
        $users = User::all();

        return view('Operasional.intruksiJalan.editIntruksi', compact('intruksiJalan', 'kendaraans', 'orders','users'));
    }

    public function update(Request $request, $id)
    {
        // Validasi dan update data Intruksi Jalan
        $request->validate([
            'no_surat_jalan' => 'required|string|max:255',
            'order_id' => 'required|exists:orders,id',
            'driver_id' => 'required|exists:users,id',
            'kenek_id' => 'nullable|exists:users,id',
            'nopol' => 'required|string|max:20',
            'tanggal_jalan' => 'required|date',
            'estimasi_waktu_ke_tujuan' => 'required|integer',
            'estimasi_jarak' => 'required|integer',
        ]);

        $intruksiJalan = IntruksiJalan::findOrFail($id);
        $intruksiJalan->update($request->all());

        return redirect()->route('intruksiJalan.index')->with('success', 'Intruksi Jalan berhasil diupdate.');
    }

    public function destroy($id)
    {
        // Hapus data Intruksi Jalan
        $intruksiJalan = IntruksiJalan::findOrFail($id);
        $intruksiJalan->delete();

        return redirect()->route('intruksiJalan.index')->with('success', 'Intruksi Jalan berhasil dihapus.');
    }
}
