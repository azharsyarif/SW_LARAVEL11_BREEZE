<?php

namespace App\Http\Controllers;

use App\Imports\AbsensiImport;
use App\Models\Absensi;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index()
    {
        $absensis = Absensi::all();
        return view('HR.Absensi.absensiIndex', compact('absensis'));
    }

    public function create()
    {
        return view('attendances.import');
    }

    public function store(Request $request)
    {
        $absen = new Absensi();
        $absen->nip = $request->input('nip');
        $absen->tanggal = $request->input('tanggal');
        $absen->jam_masuk = $request->input('jam_masuk');
        $absen->jam_keluar = $request->input('jam_keluar');
        $absen->save();
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dibuat!');
    }

}
