<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\ServiceKendaraan;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        $services = ServiceKendaraan::all();
        $kendaraans = Kendaraan::all();

        // Menggunakan whereHas untuk mendapatkan pengguna dari divisi 'operasional'
        $drivers = User::whereHas('divisions', function($query) {
            $query->where('name', 'operasional');
        })->get();

        return view('Operasional.serviceKendaraan.serviceKendaraanIndex', compact('services', 'kendaraans', 'drivers'));
    }

    public function viewCreate(){
        $services = ServiceKendaraan::all();
        $kendaraans = Kendaraan::all();

        $drivers = User::whereHas('divisions', function($query) {
            $query->where('name', 'operasional');
        })->get();

        return view('Operasional.serviceKendaraan.createService', compact('services', 'kendaraans', 'drivers'));


    }



    public function create(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'driver_id' => 'required|exists:users,id',
            'total_service' => 'required|numeric',
            'upload_dokumen' => 'nullable|file',
            'item_name.*' => 'required|string',
            'item_value.*' => 'required|string',
            'desc.*' => 'nullable|string',
        ]);

        // Generate nomor service otomatis
        $lastService = ServiceKendaraan::orderBy('id', 'desc')->first();
        $lastServiceNumber = $lastService ? (int)substr($lastService->no_service, -5) : 0;
        $newServiceNumber = str_pad($lastServiceNumber + 1, 5, '0', STR_PAD_LEFT);
        $no_service = 'SRV' . $newServiceNumber;

        // Upload dokumen
        $uploadDokumen = $request->file('upload_dokumen');
        $uploadPath = $uploadDokumen ? $uploadDokumen->store('uploads', 'public') : null;

        // Simpan data service kendaraan
        $service = ServiceKendaraan::create([
            'no_service' => $no_service,
            'nopol' => $request->kendaraan_id,
            'driver_id' => $request->driver_id,
            'total_service' => $request->total_service,
            'upload_dokumen' => $uploadPath,
        ]);

        // Simpan kondisi item kendaraan
        if ($request->has('item_name')) {
            foreach ($request->item_name as $index => $itemName) {
                $service->kendaraanItemConditions()->create([
                    'item_name' => $itemName,
                    'item_value' => $request->item_value[$index],
                    'desc' => $request->desc[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('service.index')->with('success', 'Data service kendaraan berhasil ditambahkan');
    }

    public function viewEditService($id)
    {
        $serviceKendaraan = ServiceKendaraan::with('kendaraanItemConditions')->findOrFail($id);
        $kendaraans = Kendaraan::all();
        $drivers = User::whereHas('divisions', function($query) {
            $query->where('name', 'operasional');
        })->get();

        return view('Operasional.serviceKendaraan.editService', compact('serviceKendaraan', 'kendaraans', 'drivers'));
    }

    public function updateService(Request $request, $id)
{
    $request->validate([
        'nopol' => 'required',
        'driver_id' => 'required',
        'total_service' => 'required|numeric',
        'upload_dokumen' => 'nullable|file|mimes:jpg,png,pdf,docx',
        'item_name.*' => 'required|string',
        'item_value.*' => 'required|string',
        'desc.*' => 'nullable|string',
    ]);

    $serviceKendaraan = ServiceKendaraan::findOrFail($id);
    $serviceKendaraan->nopol = $request->nopol;
    $serviceKendaraan->driver_id = $request->driver_id;
    $serviceKendaraan->total_service = $request->total_service;

    if ($request->hasFile('upload_dokumen')) {
        $file = $request->file('upload_dokumen');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        $serviceKendaraan->upload_dokumen = $filename;
    }

    $serviceKendaraan->save();

    // Handle item conditions
    $serviceKendaraan->kendaraanItemConditions()->delete();
    foreach ($request->item_name as $index => $name) {
        $serviceKendaraan->kendaraanItemConditions()->create([
            'item_name' => $name,
            'item_value' => $request->item_value[$index],
            'desc' => $request->desc[$index] ?? null,
        ]);
    }

    return redirect()->route('service.index')->with('success', 'Service Kendaraan berhasil diperbarui.');
}


    public function destroyService($id)
    {
        $service = ServiceKendaraan::findOrFail($id);
        $service->delete();

        return redirect()->route('service.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
