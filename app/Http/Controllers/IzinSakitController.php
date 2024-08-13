<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzinSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinSakitController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->input('tab', 'Pending');

        if ($tab == 'history') {
            $izinSakits = PengajuanIzinSakit::where('karyawan_id', $user->id)
                ->whereIn('status', ['Diterima', 'Ditolak'])
                ->with(['karyawan', 'approvedBy'])
                ->get();
        } else {
            $izinSakits = PengajuanIzinSakit::where('karyawan_id', $user->id)
                ->where('status', 'Pending')
                ->with(['karyawan', 'approvedBy'])
                ->get();
        }
        // dd($izinSakits);

        return view('HR.izinsakit.izinsakitIndex', compact('izinSakits', 'user', 'tab'));
    }


    

    
    public function createIndex()
    {
        $user = Auth::user(); // Misalnya, mengambil user yang sedang login
        $izinSakits = PengajuanIzinSakit::with('karyawan')->get();
        return view('HR.izinsakit.createIzinSakit', compact('izinSakits','user'));
    }

    public function store(Request $request)
    {
        // Validasi data dari form
        $validatedData = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'jenis' => 'required|in:izin,sakit', // Menambahkan validasi untuk jenis izin
            'bukti_dokumen' => 'nullable|file|max:2048', // Maksimal 2MB
        ]);
    
        $izinSakit = new PengajuanIzinSakit();
        $izinSakit->karyawan_id = Auth::id();
        $izinSakit->jenis = $validatedData['jenis'];
        $izinSakit->tanggal_mulai = $validatedData['tanggal_mulai'];
        $izinSakit->tanggal_akhir = $validatedData['tanggal_akhir'];
        $izinSakit->alasan = $validatedData['alasan'];
    
        // Mengelola bukti dokumen jika ada
        if ($request->hasFile('bukti_dokumen')) {
            $file = $request->file('bukti_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_dokumen', $filename);
            $izinSakit->bukti_dokumen = $filename;
        }
    
        // Menyimpan pengajuan izin sakit
        $izinSakit->save();
    
        return redirect()->route('pengajuan.izin-sakit.index')
        ->with('success', 'Pengajuan izin sakit berhasil disimpan.');
    }
    
}
