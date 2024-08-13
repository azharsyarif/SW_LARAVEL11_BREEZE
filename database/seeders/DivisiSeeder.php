<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('divisions')->insert([
            ['name' => 'operasional', 'description' => 'Operasional'],
            ['name' => 'marketing', 'description' => 'Marketing'],
            ['name' => 'finance', 'description' => 'Finance'],
            ['name' => 'direksi', 'description' => 'Direksi'],
            ['name' => 'hr', 'description' => 'HR'],
        ]);
    }
}
