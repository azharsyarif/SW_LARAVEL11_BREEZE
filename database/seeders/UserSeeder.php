<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            [
                'name' => 'Azhar',
                'email' => 'azhar@example.com',
                'password' => Hash::make('123456'),
                'role_id' => 1,
                'status' => 'active',
                'position_id' => 1,
                'tanggal_join' => Carbon::now(),
                'alamat' => 'Jl. Contoh Alamat No.1',
                'emergency_call_nama' => 'Emergency Contact Name',
                'emergency_call_nomor' => '08123456789',
                'jatah_cuti' => 12,
            ],
            // Tambahkan lebih banyak user jika diperlukan
        ]);
        
    }
}
