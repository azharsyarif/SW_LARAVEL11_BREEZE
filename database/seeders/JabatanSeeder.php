<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            'name' => 'spv',
            'description' => 'Spv',
        ]);
        DB::table('positions')->insert([
            'name' => 'manager',
            'description' => 'Manager',
        ]);
        DB::table('positions')->insert([
            'name' => 'staff',
            'description' => 'Staff',
        ]);
    }
}
