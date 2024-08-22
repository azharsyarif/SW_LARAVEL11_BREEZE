<?php

namespace App\Http\Controllers;

use App\Models\PengajuanCuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }
    
        $tab = $request->input('tab', 'pending');
    
        if ($tab == 'history') {
            // Fetch approved or rejected leave requests for the current user
            $cutis = PengajuanCuti::where('karyawan_id', $user->id)
                ->whereIn('status', ['Diterima', 'Ditolak'])
                ->with(['approvedBy', 'karyawan'])
                ->get();
    
            // Calculate remaining leave based on the approved requests
            $remainingLeave = $user->jatah_cuti;
            foreach ($cutis as $cuti) {
                if ($cuti->status == 'Diterima') {
                    $remainingLeave--;
                }
            }
        } else {
            $cutis = PengajuanCuti::where('karyawan_id', $user->id)
                ->where('status', 'Pending')
                ->with(['approvedBy', 'karyawan'])
                ->get();
    
            $remainingLeave = $user->jatah_cuti;
        }
    
        return view('HR.cuti.cutiIndex', compact('cutis', 'user', 'tab', 'remainingLeave'));
    }
    
    public function viewCreate()
    {
        $user = Auth::user();
        $cutis = PengajuanCuti::where('karyawan_id', $user->id)->get();

        return view('HR.cuti.createCuti', compact('cutis','user'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required',
        ]);

        // Create a new leave request
        $cuti = new PengajuanCuti();
        $cuti->karyawan_id = Auth::id(); // Get the authenticated user's ID
        $cuti->tanggal_mulai = $request->tanggal_mulai;
        $cuti->tanggal_akhir = $request->tanggal_akhir;
        $cuti->alasan = $request->alasan;
        $cuti->status = 'Pending'; // Default status is Pending
        $cuti->save();

        return redirect()->route('pengajuan.cuti.index')
                        ->with('success', 'Pengajuan cuti berhasil disimpan.');
    }

}
