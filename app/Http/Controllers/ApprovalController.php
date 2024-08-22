<?php
namespace App\Http\Controllers;

use App\Models\PengajuanCuti;
use App\Models\PengajuanIzinSakit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        // Determine the current tab (either 'pending' or 'history')
        $tab = $request->query('tab', 'pending'); // Default to 'pending' if no tab is specified
    
        // Count the number of pending requests for both cuti and izin sakit
        $pendingCutiCount = PengajuanCuti::where('status', 'Pending')->count();
        $pendingIzinSakitCount = PengajuanIzinSakit::where('status', 'Pending')->count();
        $pendingCount = $pendingCutiCount + $pendingIzinSakitCount;
    
        // Count the number of history requests (approved or rejected) for both cuti and izin sakit
        $historyCutiCount = PengajuanCuti::whereIn('status', ['Diterima', 'Ditolak'])->count();
        $historyIzinSakitCount = PengajuanIzinSakit::whereIn('status', ['Diterima', 'Ditolak'])->count();
        $historyCount = $historyCutiCount + $historyIzinSakitCount;
    
        // Fetch the data based on the current tab
        if ($tab == 'pending') {
            $pengajuanCuti = PengajuanCuti::with('karyawan')->where('status', 'Pending')->get();
            $pengajuanIzinSakit = PengajuanIzinSakit::with('karyawan')->where('status', 'Pending')->get();
        } else {
            $pengajuanCuti = PengajuanCuti::with('karyawan')->whereIn('status', ['Diterima', 'Ditolak'])->get();
            $pengajuanIzinSakit = PengajuanIzinSakit::with('karyawan')->whereIn('status', ['Diterima', 'Ditolak'])->get();
        }
    
        // Merge the two collections and sort by 'created_at'
        $pengajuan = $pengajuanCuti->merge($pengajuanIzinSakit)->sortByDesc('created_at');
    
        // Pass the data and the tab variable to the view
        return view('HR.approvalCutiIzinSakit', compact('pengajuan', 'tab', 'pendingCount', 'historyCount'));
    }
    
    

    


    public function approveCuti($id)
    {
        $cuti = PengajuanCuti::findOrFail($id);

        // Update status to 'Diterima'
        $cuti->status = 'Diterima';
        $cuti->approved_by = Auth::id();
        $cuti->save();

        $user = User::findOrFail($cuti->karyawan_id);
        $user->jatah_cuti -= 1;
        $user->save();

        return redirect()->route('approval.index')->with('success', 'Cuti berhasil disetujui');
    }

    public function rejectCuti($id)
    {
        $cuti = PengajuanCuti::findOrFail($id);

        $cuti->status = 'Ditolak';
        $cuti->approved_by = Auth::id(); 
        $cuti->save();

        return redirect()->route('approval.index')->with('error', 'Cuti berhasil ditolak');
    }

    public function approveIzinSakit($id)
    {
        $izinSakit = PengajuanIzinSakit::findOrFail($id);

        // Update status to 'Diterima'
        $izinSakit->status = 'Diterima';
        $izinSakit->approved_by = Auth::id();
        $izinSakit->save();

        return redirect()->route('approval.index')->with('success', 'Pengajuan izin sakit berhasil disetujui');
    }

    public function rejectIzinSakit($id)
    {
        $izinSakit = PengajuanIzinSakit::findOrFail($id);

        // Update status to 'Ditolak'
        $izinSakit->status = 'Ditolak';
        $izinSakit->approved_by = Auth::id();
        $izinSakit->save();

        return redirect()->route('approval.index')->with('error', 'Pengajuan izin sakit berhasil ditolak');
    }
}
