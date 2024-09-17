<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr; // Import this at the top of your file
use App\Models\Divisions;
use App\Models\Positions;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function userIndex(){
        $users = User::all();
        $roles = Role::all();
        $divisions = Divisions::all();

        return view('HR.user.userIndex', compact('users', 'roles', 'divisions'));
    }

    public function viewCreate(){
        $roles = Role::all();
    $positions = Positions::all();
    $divisions = Divisions::all();

    return view('HR.user.createUser', compact('roles', 'positions', 'divisions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'tanggal_join' => 'nullable|date',
            'alamat' => 'nullable|string',
            'emergency_call_nama' => 'nullable|string|max:255',
            'emergency_call_nomor' => 'nullable|string|max:20',
            'jatah_cuti' => 'nullable|integer',
            'divisions' => 'nullable|array',
            'divisions.*' => 'exists:divisions,id',
            'upload_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Mengunggah file KTP jika ada
        if ($request->hasFile('upload_ktp')) {
            $file = $request->file('upload_ktp');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/foto_ktp', $filename);
            $validatedData['upload_ktp'] = $path;
        }

        // Generate nomor karyawan
        $validatedData['no_karyawan'] = $this->generateNoKaryawan();

        // Simpan data user
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->role_id = $validatedData['role_id'];
        $user->status = $validatedData['status'];
        $user->position_id = $validatedData['position_id'];
        $user->tanggal_join = $validatedData['tanggal_join'];
        $user->alamat = $validatedData['alamat'];
        $user->emergency_call_nama = $validatedData['emergency_call_nama'];
        $user->emergency_call_nomor = $validatedData['emergency_call_nomor'];
        $user->jatah_cuti = $validatedData['jatah_cuti'];
        $user->upload_ktp = $validatedData['upload_ktp'] ?? null;
        $user->no_karyawan = $validatedData['no_karyawan'];
        $user->save();

        // Simpan relasi many-to-many
        if (isset($validatedData['divisions'])) {
            $user->divisions()->attach($validatedData['divisions']);
        }

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }


    // Fungsi untuk menghasilkan nomor karyawan unik dengan format KRY-(Angka)
    private function generateNoKaryawan()
    {
        $lastUser = User::orderBy('id', 'desc')->first();
        $lastNoKaryawan = $lastUser ? $lastUser->no_karyawan : null;

        if ($lastNoKaryawan) {
            // Ambil angka terakhir dari nomor karyawan sebelumnya
            $lastNumber = (int)str_replace('KR/SW-', '', $lastNoKaryawan);
            $newNoKaryawan = $lastNumber + 1;
        } else {
            // Jika belum ada, mulai dari 1001
            $newNoKaryawan = 1001;
        }

        return 'KRY-' . str_pad($newNoKaryawan, 4, '0', STR_PAD_LEFT);
    }



    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $positions = Positions::all();
        $divisions = Divisions::all();

        return view('HR.user.editUser', compact('user', 'roles', 'positions', 'divisions'));
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|string|min:6',
        'role_id' => 'required|exists:roles,id',
        'status' => 'required|string',
        'position_id' => 'required|exists:positions,id',
        'tanggal_join' => 'nullable|date',
        'alamat' => 'nullable|string',
        'emergency_call_nama' => 'nullable|string|max:255',
        'emergency_call_nomor' => 'nullable|string|max:20',
        'jatah_cuti' => 'nullable|integer',
        'divisions' => 'nullable|array',
        'divisions.*' => 'exists:divisions,id',
        'upload_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Handle file upload if present
    if ($request->hasFile('upload_ktp')) {
        // Delete old file if exists
        if ($user->upload_ktp) {
            \Storage::delete($user->upload_ktp);
        }

        $file = $request->file('upload_ktp');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/foto_ktp', $filename);
        $validatedData['upload_ktp'] = $path;
    } else {
        $validatedData['upload_ktp'] = $user->upload_ktp; // retain existing file if no new file is uploaded
    }

    // Update user data
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    if ($request->filled('password')) {
        $user->password = Hash::make($validatedData['password']);
    }
    $user->role_id = $validatedData['role_id'];
    $user->status = $validatedData['status'];
    $user->position_id = $validatedData['position_id'];
    $user->tanggal_join = Arr::get($validatedData, 'tanggal_join', $user->tanggal_join); // Use Arr::get to avoid undefined key error
    $user->alamat = Arr::get($validatedData, 'alamat', $user->alamat);
    $user->emergency_call_nama = Arr::get($validatedData, 'emergency_call_nama', $user->emergency_call_nama);
    $user->emergency_call_nomor = Arr::get($validatedData, 'emergency_call_nomor', $user->emergency_call_nomor);
    $user->jatah_cuti = Arr::get($validatedData, 'jatah_cuti', $user->jatah_cuti);
    $user->upload_ktp = $validatedData['upload_ktp'];
    $user->save();

    // Update many-to-many relationship
    if (isset($validatedData['divisions'])) {
        $user->divisions()->sync($validatedData['divisions']);
    } else {
        $user->divisions()->detach();
    }

    return redirect()->route('user.index')->with('success', 'User updated successfully.');
}


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }

    public function viewProfile()
    {
        $roles = Role::all();
        $positions = Positions::all();
        $divisions = Divisions::all();
        $user = Auth::user();

        return view('HR.user.userProfile', compact('user', 'roles', 'positions', 'divisions'));
    }

}
